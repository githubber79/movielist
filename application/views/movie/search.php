<!DOCTYPE html>
<html>
	<head>
		<title>Sakila's Movie Catalogue | Search</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/libs/jquery/jquery-ui-bootstrap/custom-theme/jquery-ui-1.10.3.custom.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/libs/jquery/jquery-ui-bootstrap/custom-theme/jquery-ui-1.10.3.theme.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/libs/jquery/jquery-ui-bootstrap/custom-theme/jquery.ui.1.10.3.ie.css" />
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
					<h1>Search what movie you want to</h1>
				</div>
				<div id="movie_app">
				</div>
			</div>
		</div>
		<!-- footer -->
		<?php $this->load->view('main/footer'); ?>
			
		<script src="<?php echo base_url(); ?>/assets/libs/reactjs/react.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/reactjs/JSXTransformer.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/jquery/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/jsx">
		var movie_page = 1;

		var MoviePager = React.createClass({

			render: function(){
				return (
					<ul className="pager">
					  <li onClick={this.props.prevEvent} className="previous"><a href="javascript:void(0);">&larr; Older</a></li>
					  <li onClick={this.props.nextEvent} className="next"><a href="javascript:void(0);">Newer &rarr;</a></li>
					</ul>
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
					    	<div className="col-md-3">
					    		<ul className="list-group">
								  <li className="list-group-item">
								    Rental Duration: 
								    <span className="badge">{this.props.rental_duration} days</span>
								  </li>
								  <li className="list-group-item">
								    Rental Rates: 
								    <span className="badge">${this.props.rental_rate} / days</span>
								  </li>
								  <li className="list-group-item">
								    Replacement Cost: 
								    <span className="badge">${this.props.replacement_cost}</span>
								  </li>
								</ul>
					    	</div>
					    	<div className="col-md-9">
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

		var MovieList = React.createClass({
			getInitialState: function()
			{
				return { 
							movie_list:[], 
							search_keyword:"zxc",
							rental_duration: [],
							rental_rate: [],
							replacement_cost:[],
							video_length:[]
						};
			},
			handlePrev: function(){
				movie_page -= 1;
				this.loadMovie(movie_page);
			},
			handleNext: function(){
				movie_page += 1;
				this.loadMovie(movie_page);
			},
			loadMovie : function(page){
				react = this;
				post_data = 'keyword='+this.state.search_keyword;
				post_data += '&rental_duration[min]='+this.state.rental_duration[0];
				post_data += '&rental_duration[max]='+this.state.rental_duration[1];
				post_data += '&rental_rate[min]='+this.state.rental_rate[0];
				post_data += '&rental_rate[max]='+this.state.rental_rate[1];
				post_data += '&replacement_cost[min]='+this.state.replacement_cost[0];
				post_data += '&replacement_cost[max]='+this.state.replacement_cost[1];
				post_data += '&video_length[min]='+this.state.video_length[0];
				post_data += '&video_length[max]='+this.state.video_length[1];
				
				$.ajax({
		            url : 'http://localhost/movielist/index.php/movie/search_movie/'+movie_page,
		            data: post_data,
		            type: 'POST',
		            beforeSend : function(xhr){
		            },
		            success : function(data){
		                var res = data;
		                if (react.isMounted()) {
				        	react.setState({
				        		movie_list: res.data
				        	});
				      	}
					}
		        }).done(function(){

		        });
			},
			handleSearching: function(){
				this.setState({
		        		search_keyword: $('#search_keyword').val(),
		        		rental_duration: $('#slider_rental_duration').slider('values'),
		        		rental_rate: $('#slider_rental_rate').slider('values'),
		        		rental_rate: $('#slider_rental_rate').slider('values'),
		        		replacement_cost: $('#slider_replacement_cost').slider('values'),
		        		replacement_cost: $('#slider_replacement_cost').slider('values'),
		        		video_length: $('#slider_video_length').slider('values'),
	        	});
		      	
		      	this.loadMovie(1);
			},
			componentDidMount: function() {
				this.loadMovie(1);
				
			},
			render: function() {
				function createMovieItem(mov) {
					return <Movie title={mov.title} description={mov.description} rental_duration={mov.rental_duration} 
									rental_rate={mov.rental_rate} replacement_cost={mov.replacement_cost} 
									dubbed={mov.dubbed} film_length={mov.film_length} special_features={mov.special_features}
									release_year={mov.release_year} rating={mov.rating} category={mov.category} 
									total_actor={mov.total_actor} film_id={mov.film_id} />;
				}


				return (
					<div>
						<MovieSearch ops={this.handleSearching} />
						<MoviePager prevEvent={this.handlePrev} nextEvent={this.handleNext} /> 
						<div className="list-group">
							{this.state.movie_list.map(createMovieItem)}
						</div>
						<MoviePager prevEvent={this.handlePrev} nextEvent={this.handleNext} /> 
					</div>

				);
			}
		});
		
		var MovieSearch = React.createClass({
			componentDidMount: function(){
				setTimeout(function(){
					$('#slider_rental_duration').slider({
					    range: true,
					    values: [1, 2],
					    min: 1,
						max: 7
					});

					$('#slider_rental_rate').slider({
					    range: true,
					    values: [1.0, 2.0],
					    min: 0.1,
						max: 5.0,
						step: 0.1
					});

					$('#slider_replacement_cost').slider({
					    range: true,
					    values: [15.0, 20.0],
					    min: 1.0,
						max: 30.0,
						step: 0.1
					});

					$('#slider_video_length').slider({
					    range: true,
					    values: [120, 140],
					    max:150,
					    min:30,
					});
				}, 1000);
			},
			render: function(){
				return (<div>
							<form role="form">
							  <div className="form-group">
							    <label>Searching keyword</label>
							    <input style={{"text-align":"center", 'font-size':'20px'}} type="text" className="form-control" id="search_keyword" placeholder="Type your keyword here" />
							  </div>
							  <div className="form-group">
							  	<label>Rental Duration (1 - 7 days)</label>
							  	<div id="slider_rental_duration">
							  	</div>
							  </div>
							  <div className="form-group">
							  	<label>Rental Rates ($0.1 - $5.0)</label>
							  	<div id="slider_rental_rate">
							  	</div>
							  </div>
							  <div className="form-group">
							  	<label>Replacement Cost ($1.0 - $30.0)</label>
							  	<div id="slider_replacement_cost">
							  	</div>
							  </div>
							  <div className="form-group">
							  	<label>Video Length (30 - 150 minutes)</label>
							  	<div id="slider_video_length">
							  	</div>
							  </div>
							  <a onClick={this.props.ops} href="javascript:void(0);" className="btn btn-primary">Help me searching</a>
							</form>
						</div>);
			}
		});
	
		var MovieApp = React.createClass({
			
			render: function(){
				return ( 
					<MovieList />
				);
			}
		});

		// render komponen utama
		React.render(<MovieApp />, document.getElementById('movie_app'));
		</script>
	</body>	
</html>