<!DOCTYPE html>
<html>
	<head>
		<title>Sakila's Movie Catalogue | Credit</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/libs/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/main.css" />
	</head>
	<body>
		<div id="wrap">
			<!-- navigation -->
			<?php $this->load->view('main/header'); ?>
			<!-- main content -->
			<div id="credit" class="container">
			</div>
		</div>
		<!-- footer -->
		<?php $this->load->view('main/footer'); ?>
			
		<script src="<?php echo base_url(); ?>/assets/libs/reactjs/react.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/reactjs/JSXTransformer.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>/assets/libs/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/jsx">
		
		var CreditItem = React.createClass({
			render: function(){
				return (
						<div style={{margin:'0px 5px 10px 5px'}} className="list-group-item">
						    <h3 className="list-group-item-heading">{this.props.name}</h3>
						    <hr />
						    <div className="row">
						    	<div className="col-md-3" style={{'text-align':'center'}}>
								    <img style={{'height':'auto', 'width':'150px'}} src={this.props.url} />
								</div>
						    	<div className="col-md-9">
								    <p className="list-group-item-text">
								    	{this.props.description}
								    </p>
								</div>
						    </div>
						 </div>
				);
			}
		});

		var CreditApp = React.createClass({
			getInitialState: function(){
				return {
					credit_list: [
						{name:'React.js', url:"http://localhost/movielist/assets/img/credits/reactjs.png", description:'React.js is javascript library created by Facebook for build sophisticated and manageable user interface for web application. I use React.js to create more reusable component that manipulated by Javascript in every page of this website. So i did not to have concatenate a large string contain HTML text anymore.'},
						{name:'Twitter Bootstrap', url:"http://localhost/movielist/assets/img/credits/bootstrap.png", description:'Twitter Bootstrap is user interface library for web application created by Twitter Inc. for people who want to build sophisticated website with very fast building time. I use Twitter Bootstrap to make the frontend development have a more fast building time.'},
						{name:'jQuery', url:"http://localhost/movielist/assets/img/credits/jquery.png", description:'jQuery is famous library for the easy way to manipulate DOM created by John Resig. Under jQuery Foundation, jQuery has large community in the web developer worldwide community. I use jQuery for AJAX that integrate with React.js'},
						{name:'PHP', url:"http://localhost/movielist/assets/img/credits/php.png", description:'PHP (Personal Homepage Hypertext Preprocessor) is programming language for dynamic website development created by Rasmus Lerdorf and Zend Technologies. I use PHP because its easy to develop a dynamic website.'},
						{name:'CodeIgniter', url:"http://localhost/movielist/assets/img/credits/codeigniter.png", description:'CodeIgniter is web framework for PHP that can make you develop website more better. CodeIgniter have a good documentation for you to learn CodeIgniter easily.'},
						{name:'MySQL', url:"http://localhost/movielist/assets/img/credits/mysql.png", description:'I use MySQL to host a Sakila Movie Rental Database. So i use the dataset to create this example React.js website.'},
					]
				}
			},
			createItem: function(item){
				return <CreditItem name={item.name} url={item.url} description={item.description} />;
				
			},
			render: function(){
				return ( 
					<div>
						<div className="page-header">
							<h1>Credits</h1>
						</div>
						<div className="list-group">
							{this.state.credit_list.map(this.createItem)}
						</div>
					</div>
				);
			}
		});

		// render komponen utama
		React.render(<CreditApp />, document.getElementById('credit'));
		</script>
	</body>	
</html>