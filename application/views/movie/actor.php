<!DOCTYPE html>
<html>
	<head>
		<title>Sakila's Movie Catalogue | Actor List</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/libs/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/main.css" />
	</head>
	<body>
		<div id="wrap">
			<!-- navigation -->
			<?php $this->load->view('main/header'); ?>
			<!-- main content -->
			<div class="container">
				<div class="page-header">
					<h1>Actor List</h1>
				</div>
				<div id="movie_list">
				</div>
			</div>
		</div>
		<!-- footer -->
		<?php $this->load->view('main/footer'); ?>
			
		<script src="<?php echo base_url(); ?>/assets/libs/reactjs/react.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/reactjs/JSXTransformer.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/jsx">
		var actor_page = 1;

		var ActorPager = React.createClass({

			render: function(){
				return (
					<ul className="pager">
					  <li onClick={this.props.prevEvent} className="previous"><a href="javascript:void(0);">&larr; Older</a></li>
					  <li onClick={this.props.nextEvent} className="next"><a href="javascript:void(0);">Newer &rarr;</a></li>
					</ul>
				);
			}
		});

		var Actor = React.createClass({
			render: function() {
				actor_url = ("http://localhost/movielist/index.php/movie/actor/"+this.props.actor_id);
					
				return(

					<div style={{margin:'0px 5px 10px 5px'}} className="list-group-item">
					    <h3 className="list-group-item-heading"><a href={actor_url} >{this.props.first_name} {this.props.last_name}</a></h3>
					    <hr />
					    <div className="row">
					    	<div className="col-md-3">
					    		<ul className="list-group">
								  <li className="list-group-item">
								    Total Movie: 
								    <span className="badge">{this.props.total_movie} movie</span>
								  </li>
								</ul>
					    	</div>
					    	<div className="col-md-9">
							    <p className="list-group-item-text">
							    	He was starring several film which genre in <b>{this.props.movie_genre}</b>. He also has starred movie with <strong className="label label-primary">{this.props.total_partner} actor/actrees</strong>  in same movie.
							    </p>
							</div>
					    </div>
					    
					 </div>
				);
			}
		});

		var ActorList = React.createClass({
			getInitialState: function()
			{
				return { actor_list:[], prev_btn_status: false };
			},
			handlePrev: function(){
				actor_page -= 1;
				this.loadActor(actor_page);
			},
			handleNext: function(){
				actor_page += 1;
				this.loadActor(actor_page);
			},
			loadActor : function(page){
				$.get('http://localhost/movielist/index.php/movie/get_actor/'+actor_page, function(result) {
			      	if (this.isMounted()) {
			        	this.setState({
			        		actor_list: result.data
			        	});
			      	}
			    }.bind(this));
			},
			componentDidMount: function() {
				this.loadActor(1);    
			},
			render: function() {
				function createActorItem(item) {
					console.log(item);
					return <Actor actor_id={item.actor_id} first_name={item.first_name} last_name={item.last_name} total_movie={item.total_movie} 
							movie_genre={item.movie_genre} total_partner={item.total_partner} />;
				}

				return (
					<div className="list-group">
						<ActorPager prevEvent={this.handlePrev} nextEvent={this.handleNext} /> 
						{this.state.actor_list.map(createActorItem)}
						<ActorPager prevEvent={this.handlePrev} nextEvent={this.handleNext} /> 
					</div>

				);
			}
		});

		var ActorApp = React.createClass({
			
			render: function(){
				return ( 
					<ActorList />
				);
			}
		});

		// render komponen utama
		React.render(<ActorApp />, document.getElementById('movie_list'));
		</script>
	</body>	
</html>