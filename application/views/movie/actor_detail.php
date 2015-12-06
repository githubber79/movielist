<!DOCTYPE html>
<html>
	<head>
		<title>Sakila's Movie Catalogue | Movie</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/libs/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/main.css" />
	</head>
	<body>
		<div id="wrap">
			<!-- navigation -->
			<?php $this->load->view('main/header'); ?>
			<!-- main content -->
			<div id="actor_detail" class="container">
			</div>
		</div>
		<!-- footer -->
		<?php $this->load->view('main/footer'); ?>
			
		<script src="<?php echo base_url(); ?>/assets/libs/reactjs/react.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/reactjs/JSXTransformer.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/jsx">
		var actor_id = <?php echo $actor_id ?>;

		var ActorPartner = React.createClass({
			getInitialState: function(){
				return {movie_star_list:[]};
			},
			componentDidMount: function() {
				this.loadMovieStar();    
			},
			loadMovieStar : function(){
				console.log(this.props.actor2_id);

				$.get('http://localhost/movielist/index.php/movie/get_actor_by/partner/'+actor_id, function(result) {
					console.log(result);
			      	if (this.isMounted()) {
			        	this.setState({
			        		movie_star_list: result.data
			        	});
			      	}
			    }.bind(this));
			},
			createMovieStarItem: function(item){
				console.log(item);
				return <MovieStarItem actor_id={item.actor_id} first_name={item.first_name} last_name={item.last_name} />;
			},
			render: function() {
				return (
				    <div className="row">
				    	<div className="col-md-12">
				    		<br/>
						    <ul>
						    	{this.state.movie_star_list.map(this.createMovieStarItem)}
						    </ul>
				    	</div>
				    </div>
				);
			}
		});

		var MovieStarItem = React.createClass({
			render: function(){
				actor_url = ("http://localhost/movielist/index.php/movie/actor/"+this.props.actor_id);
				return (
					<li><a href={actor_url}>{this.props.first_name} {this.props.last_name}</a></li>
				);	
			}	
		});

		var Movie = React.createClass({
			render: function() {
				movie_url = ("http://localhost/movielist/index.php/movie/index/"+this.props.film_id);
				
				return(
					<div style={{margin:'0px 5px 10px 5px'}} className="list-group-item">
					    <h3 className="list-group-item-heading"><a href={movie_url}>{this.props.title}</a></h3>
					    <span className="label label-success">{this.props.category}</span> <span className="label label-info"> release year: {this.props.release_year}</span> <span className="label label-danger"> rating: {this.props.rating}</span>
					    <hr />
					    <div className="row">
					    	<div className="col-md-12">
							    <p className="list-group-item-text">
							    	{this.props.description}.
							    </p>
							    <br/>
							    <ul>
							    	<li>Dubbed: {this.props.dubbed}</li>
							    	<li>Length: {this.props.film_length} minutes</li>
							    	<li>Special Features: {this.props.special_features}</li>
							    	<li>Wellknown Actor who played in this film: {this.props.total_actor} persons</li>
							    </ul>
					    	</div>
					    </div>
					 </div>
				);
			}
		});

		var ActorStarredMovie = React.createClass({
			getInitialState: function(){
				return { movie_list: [] }
			},
			loadMovie : function(){
				$.get('http://localhost/movielist/index.php/movie/get_movie_by/actor_id/'+actor_id, function(result) {
					// console.log(result);
			      	if (this.isMounted()) {
			        	this.setState({
			        		movie_list: result.data
			        	});
			      	}
			    }.bind(this));
			},
			componentDidMount: function() {
				this.loadMovie();    
			},
			createMovieItem : function(mov) {
					// console.log(mov);
					return <Movie title={mov.title} description={mov.description} rental_duration={mov.rental_duration} 
									rental_rate={mov.rental_rate} replacement_cost={mov.replacement_cost} 
									dubbed={mov.dubbed} film_length={mov.film_length} special_features={mov.special_features}
									release_year={mov.release_year} rating={mov.rating} category={mov.category} 
									total_actor={mov.total_actor} film_id={mov.film_id} />;
			},
			render: function(){
				return (
					<div className="list-group">
						{this.state.movie_list.map(this.createMovieItem)}
					</div>
				);
			}
		});

		var ActorInfo = React.createClass({
			render: function(){
				return (
					<div className="row" style={{"text-align":"center"}}>
						<div className="col-md-4">
							<h4>Total Movie</h4>
							<span style={{"font-size":"40px", "font-weight":"bold"}}>{this.props.total_movie}</span>
						</div>
						<div className="col-md-4">
							<h4>Total Partner</h4>
							<span style={{"font-size":"40px", "font-weight":"bold"}}>{this.props.total_partner}</span>
						</div>
						<div className="col-md-4">
							<h4>Play in Genre</h4>
							<p style={{"word-wrap":"break-word"}}>{this.props.movie_genre}</p>
						</div>
					</div>
				);	
			}
		});

		var ActorDetail = React.createClass({
			getInitialState: function()
			{
				return { actor_data:{}, actor_id: actor_id };
			},
			loadActor : function(){
				$.get('http://localhost/movielist/index.php/movie/get_actor_by/id/'+actor_id, function(result) {
					if (this.isMounted()) {
			        	this.setState({
			        		actor_data: result.data
			        	});
			      	}
			    }.bind(this));
			},
			enableTab: function(){
				$('#myTab a').click(function (e) {
				  // e.preventDefault()
				  $(this).tab('show')
				})
			},
			componentDidMount: function() {
				this.loadActor();
				this.enableTab();
			},
			render: function() {
				return (
					<div>
						<div className="page-header">
							<h1>{this.state.actor_data.first_name} {this.state.actor_data.last_name}</h1>
						</div>
						<ActorInfo movie_genre={this.state.actor_data.movie_genre} total_movie={this.state.actor_data.total_movie} total_partner={this.state.actor_data.total_partner} />
						<hr />
						<ul className="nav nav-tabs" id="myTab">
						  <li className="active"><a href="#movie">Starred Movie</a></li>
						  <li><a href="#star">Star Partner</a></li>
						</ul>
						<div className="tab-content">
						  <div className="tab-pane active" id="movie"><br/><ActorStarredMovie actor_id={this.state.actor_data.actor_id} /></div>
						  <div className="tab-pane" id="star"><ActorPartner /></div>
						</div>
					</div>
				);
			}
		});

		var ActorDetailApp = React.createClass({
			render: function(){
				return ( 
					<ActorDetail />
				);
			}
		});

		// render komponen utama
		React.render(<ActorDetailApp />, document.getElementById('actor_detail'));
		</script>
	</body>	
</html>