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
			
		<script src="<?php echo base_url(); ?>/assets/libs/reactjs/react.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/reactjs/JSXTransformer.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/jsx">
		var actor_id = <?php echo $actor_id ?>;

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
			loadMovie : function(page){
				$.get('http://localhost/movielist/index.php/movie/get_actor_by/id/'+actor_id, function(result) {
					console.log(result);
			      	if (this.isMounted()) {
			        	this.setState({
			        		actor_data: result.data
			        	});
			      	}
			    }.bind(this));
			},
			createMovieItem: function(mov){
				console.log(mov);
				
			},
			componentDidMount: function() {
				this.loadMovie(1);    
			},
			render: function() {
				return (
					<div>
						<div className="page-header">
							<h1>{this.state.actor_data.first_name} {this.state.actor_data.last_name}</h1>
						</div>
						<ActorInfo movie_genre={this.state.actor_data.movie_genre} total_movie={this.state.actor_data.total_movie} total_partner={this.state.actor_data.total_partner} />
						<div className="list-group">
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