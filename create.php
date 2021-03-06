<?php
	session_start();
	if(!isset($_SESSION['isLoggedIn'])){
		header('Location: index.php');
		exit();
	}
?>

<!DOCTYPE html>
<html lang="pl">
	<head>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<title>Skarbonka</title>
		<meta name="description" content="Aplikacja do prowadzenia budżetu domowego">
		<meta name="keywords" content="budżet, finanse, przychody, rozliczenia">
		<meta name="author" content="Mateusz Nowakowski">
		<meta http-equiv="X-Ua-Compatible" content="IE=edge">
		
		<link rel="icon" type="image/png" href="img/icon.png">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/fontello.css">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&amp;subset=latin-ext" rel="stylesheet">
		
		<!--[if lt IE 9]>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
		<![endif]-->
		
	</head>
	
	<body>
		
		<header>
			<div class="container-fluid bg-light myColor px-0">
				<nav>
					<div class="navbar navbar-light py-0 py-sm-1 row justify-content-center align-items-center">
						<div class="col d-block d-sm-none"></div>
						<div class="col-6">
							<a class="d-flex navbar-brand my-0 py-1" href="#">
								<svg  xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-center py-1 my-1 mx-auto mx-sm-1 myColor" viewBox="-50 275 700 600" fill-rule="evenodd" width="42" height="42" role="img" focusable="false">
									<?php require('pig_body_svg.php');?>
								</svg>
								<h5 class="h3 font-weight-normal align-center ml-1 py-1 my-1 myColor d-none d-sm-inline-flex">Skarbonka</h5>
							</a>
						</div>
						<div class="col py-0 px-0 py-sm-1 d-block">
							<div class="col py-0 px-0 py-sm-1 d-block">
								<div class="d-flex justify-content-end p-2">
									<form action="sign-out.php" method="POST">
										<button type="submit" class="btn btn-link" name="sign_out" style="color:white;"> <span class="d-none d-sm-inline-flex">Wyloguj</span> <i class="demo-icon icon-logout"></i> </button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</nav>
			</div>
			
			<div class="container mt-2">
				<nav class="nav nav-tabs nav-fill row">
					<a class="nav-item nav-link active col-6"><span class="d-none d-sm-inline-flex"> Dodaj przepływ pieniężny</span><i class="demo-icon icon-plus"></i></a>
					<a class="nav-item nav-link col-6" href="bilans"><span class="d-none d-sm-inline-flex"> Przeglądaj przepływy </span> <i class="icon-eye"></i></a>
				</nav>
			</div>
		</header>
		
		<main>
			
			<div class="modal fade" id="exp_success_mod" tabindex="-1" role="dialog" aria-labelledby="exp_success_mod_lab" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header text-center">
							<h5 class="modal-title" id="exp_success_mod_lab">Sukcess!</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body text-center">
							Dodano wydatek
						</div>
						<div class="modal-footer ">
							<button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="inc_success_mod" tabindex="-1" role="dialog" aria-labelledby="inc_success_mod_lab" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header text-center">
							<h5 class="modal-title" id="inc_success_mod_lab">Sukcess!</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body text-center">
							Dodano przychód
						</div>
						<div class="modal-footer ">
							<button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			
			<div class="container text-center form_window">
				<div class="accordion row" id="accordionExample">
					
					<div class="card p-0 mx-auto col-md-8">
						<div class="card-header p-0" id="headingOne">
							<h2 class="mb-0">
								<button class="btn btn-primary p-0 m-0 <?=isset($_SESSION['exp_blad']) ? '' : 'collapsed' ?>" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="<?=isset($_SESSION['exp_blad']) ? 'true' : 'false' ?>" aria-controls="collapseOne" style="height:3rem; width:100%;">
									Dodaj wydatek
								</button>
							</h2>
						</div>
						
						<div id="collapseOne" class="collapse <?=isset($_SESSION['exp_blad']) ? 'show' : '' ?>" aria-labelledby="headingOne" data-parent="#accordionExample">
							<div class="card-body">
								<form action="add-expense.php" method="post">
									<div class="form-group">
										<div class="row py-1">
											<div class="col text-center">
												<label for="zlote2"  class="d-inline-flex p-2">Kwota:</label>
												<input type="number" name="expense_amount_zl" class="form-control d-inline-flex" id="zlote2" style="width:30%" placeholder="złoty" min="0">
												<div class="d-inline-flex p-2">,</div>
												<input type="number" name="expense_amount_gr" class="form-control d-inline-flex" id="grosze2" style="width:30%" placeholder="groszy" min="0" max="99">
											</div>
										</div>
										<div class="row py-1 justify-content-center">
											<div class="col text-center">
												<label for="dateOfExp" class="d-inline-flex p-2" > Data: </label>
												<input class="form-control d-inline-flex" name="date_of_exp" style="width:50%" type="date" id="dateOfExp">
											</div>
										</div>
										
										<div class="row justify-content-center py-1">
											<label for="type" class="col-12">Kategoria:</label>
											<div>
												<?php require('load_expenses_cat.php');?>
											</div>
											<a href="#" type="button" class="btn btn-dark mx-3" data-toggle="tooltip" data-placement="right" title="Dodaj kategorię (nieaktywne)">+</a>
										</div>
										
										<div class="row justify-content-center py-1">
											<div class="col-12"><label for="comment">Komentarz:</label></div>
											<label class="col-12"><textarea id="comment" name="comment" class="form-control" rows="3" style="resize:none"></textarea></label>
										</div>
										<?=isset($_SESSION['exp_blad']) ? $_SESSION['exp_blad'] : '' ;unset($_SESSION['exp_blad'])  ?>
										<input class="btn btn-secondary col-8 py-4" type="submit" value="Dodaj">						
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="card p-0 mx-auto col-md-8">
						<div class="card-header p-0" id="headingTwo">
							<h2 class="m-0 p-0">
								<button class="btn btn-primary p-0 m-0 collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="height:3rem; width:100%;">
									Dodaj przychod
								</button>
							</h2>
						</div>
						<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
							<div class="card-body">
								<form action="add-income.php" method="post">
									<div class="form-group">
										<div class="row py-1">
											<div class="col text-center">
												<label for="zlote" class="d-inline-flex p-2">Kwota:</label>
												<input type="number" name="income_amount_zl"  class="form-control d-inline-flex" id="zlote" style="width:30%" placeholder="złoty" min="0">
												<div class="d-inline-flex p-2">,</div>
												<input type="number" name="income_amount_gr" class="form-control d-inline-flex" id="grosze" style="width:30%" placeholder="groszy" min="0" max="99">
											</div>
										</div>
										<div class="row py-1 justify-content-center">
											<div class="col text-center">
												<label for="dateOfInc" class="d-inline-flex p-2" > Data: </label>
												<input class="form-control d-inline-flex" name="date_of_inc" style="width:50%" type="date" id="dateOfInc">
											</div>
										</div>
										
										<div class="row justify-content-center py-1"><label for="type" class="col-12">Kategoria:</label>
											<div>
												<?php require('load_incomes_cat.php');?>												
											</div>
											<a href="#" type="button" class="btn btn-dark mx-3" data-toggle="tooltip" data-placement="right" title="Dodaj kategorię (nieaktywne)">+</a>
										</div>
										
										<div class="row justify-content-center py-1">
											<div class="col-12"><label for="coment2">Komentarz:</label></div>
											<label class="col-12"><textarea id="coment2" name="comment2" class="form-control" style="resize:none;" rows="3"></textarea></label>
										</div>
										<input class="btn btn-secondary col-8 py-4" type="submit" value="Dodaj">						
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</main>
		
		<footer>
			<div class="container justify-content-center mt-5">
				<div class="row justify-content-center">
					<p class="mt-5 mb-3 text-muted"><a class="mr-1" href="#">Mateusz Nowakowski </a> &copy; 2020</p>
				</div>
			</div>
		</footer>
		
		
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		
		<script src="js/bootstrap.min.js"></script>
		<?=isset($_SESSION['exp_succ']) ? 
			'<script>
			$(document).ready(function(){
			$("#exp_success_mod").modal();
			});
			</script>' : '' ;
			unset($_SESSION['exp_succ'])  
		?>
		
		<?=isset($_SESSION['inc_succ']) ? 
			'<script>
			$(document).ready(function(){
			$("#inc_success_mod").modal();
			});
			</script>' : '' ;
			unset($_SESSION['inc_succ'])  
		?>
		
		
	</body>
</html>		