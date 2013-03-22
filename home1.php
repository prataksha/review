<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="/review/application/views/home_style.css" />
		<script src="/review/application/views/jquery-1.9.0.min.js"></script>
		<script type="text/javascript">
			var checker = true;
			var checker1 = true;
			
			function displayLogin(which){
				var helper = document.getElementById("login_box");
				var wherer = document.getElementById(which.id);
				helper.style.left = wherer.offsetLeft - 100 + "px";
				helper.style.top = wherer.offsetTop + 60 + "px";
				helper.style.opacity = 0.6;
				helper.style.display = "block";
			}
			
			function closer(which){
				if (checker == false){				
					var element = document.getElementById(which);
					element.style.opacity = 0;
					checker = true;
					return;
				}
				checker = false;
			}
			function displayReview(which){
				var give; var form;
				var childs = which.childNodes;
				for (var i = 0;i < childs.length;i++){
					if (childs[i].className == "give_review"){
						give = childs[i].id;
					}
					else if (childs[i].className == "review_form"){
						form = childs[i].id;
					}
				}
				var gstore ='#'+give;
				var fstore ='#'+form;
				if(checker1 == true){	
					$(fstore).css('height','200px');
					$(fstore).css('width','600px');
					//$(store).css('overflow','scroll');
					//$(store).css('visibility','visible');
					//store.style.opacity = 1;
					$(fstore).css('opacity','1');
					
					$(gstore).css({'background-color': '#47474D',
						'color': 'black',
						'font-style': 'bold',
						'font-size': '11px',
						'font-family': 'Impact',
						'border-top-left-radius': '5px',
						'border-top-right-radius': '5px'});
					checker1 = false;
				}
				else{
                                        $(fstore).css({
                                            '-webkit-transition': 'height 1s'
                                        });
					$(fstore).css('height','0px');
					//$(store).css('visibility','hidden');
					$(fstore).css('opacity','0');
					
					$(gstore).css({'float': 'left',
						'cursor': 'pointer',
						'padding': '10px',
						'color': '#000033',
						'font-family': 'Verdana',
						'font-size': '10px',
						'background-color': 'white',
						'border-radius':'0px'});
					checker1 = true;
				}
				
				var target = $(gstore).offset().top;
				
				// Animate the scrollTop property of html element from its current position to targetValue
				$('html,body').animate({scrollTop: target}, 'slow');
			
				// stop the default behaviour of anchor
				event.preventDefault();
			}
                        
                        function formSubmit($num){
                            var name = $('#name'+$num).val();
                            var email = $('#email'+$num).val();
                            var text = $('#text'+$num).val();
                            
                            if ( name == "" || email == "" || text == ""){
                                alert ('please fill all the fields in the form!');
                                return;
                            } else {
                                document.getElementById("frm"+$num).submit();
                                return;
                            }
                        }
                        
		</script>
    </head>
    <body>
		<div class="header">
			<div class="small_header">
				<span id="welcome_text">Welcome to Music Review!</span>
				<span id="copyright">&copy;Prataksha Gurung @ OAMK</span>
				<button id="admin_login" onclick="displayLogin(this); closer('login_box');">Admin</button>
			</div>
			<a href="/review/index.php/review">
				<div class="big_header"></div>
			</a>
		</div>
		<div id="login_box">
			<?php echo validation_errors(); ?>
                        <?php //echo form_open('verifylogin'); ?>
                        <form id="login_form" method="post" action="/review/index.php/verifylogin">
				<span class="login_field">Admin Name:</span><input type="text" name="name" size="20" />
				<span class="login_field">Password:</span><input type="password" name="password" size="20" />
				<input type="submit" value="OK"/>
			</form>
			<div id="edge">&#x25b6;</div>
		</div>
		<div class="container">
			
			<?php 
    ini_set('display_errors', '1');
$count = 0; $looper = 0;
foreach ($content as $value) {
    echo '<div class="review_container">';
    echo '<div class="review_left">';
    
    $temp;
    foreach ($images as $image) {
        if ($value['content_id'] == $image['content_id']) {
            //print_r($image);
            $temp = $value['content_id'];
            echo '<div class="review_image">';
            echo '<img src=' . $image[$value['content_id']] . ' "/>';
            echo '</div>';
        }
    }
    echo '</div>';
    
    echo '<div class="reviews">';
    echo '<div class="review_title">';
    echo $value['title'];
    echo '</div>';
    
    foreach ($reviews as $row) {
        
        $x = $value['content_id'];
        $y = $row['content_id'];
        if (($x == $y)) {
            echo '<div class="articles">';
            echo '<p>'.$row['review'];
            echo '<div class="name">';
            echo '-'.$row['name'].'</div>';
            echo '</p><hr></div>';
            $looper ++;
            //echo $looper;
        }
        if (($display == true) && ($looper >= 2)){
            $looper = 0;
            //echo $looper;
            break;
        }   
    }
    $looper = 0;
    if ($display == true){
        echo '<div class="review_detail"><a href="/review/index.php/review/index/'.$value['content_id'].'">[See all review(s)]</a></div>';
    }
    echo '<div class="give_review" id="g'.$count.'" onclick="displayReview(this.parentNode);" >[Give Review]</div>';
    echo '<br />
					<div class="review_form" id="f'.$count.'" >';
                                        $attributes = array('id' => 'frm'.$count);
					//echo form_open('review/reviewupload', $attributes);
                                        echo '<form action="/review/index.php/review/reviewupload/'.$value['content_id'].'" method="post" id="frm'.$count.'">';
					echo		'<table>
								<tr>
									<td><span class="naam">Name:</span></td>
									<td><input type="text" id="name'.$count.'" name="name" value=""/></td>
								</tr>
								<tr>
									<td><span class="email">Email:</span></td>
									<td><input type="email" id="email'.$count.'" name="email" value=""/></td>
								</tr>
								<tr>
									<td style="padding-bottom: 50px; "><span class="review_text">Your Review:</span></td>
									<td><textarea name="text" id="text'.$count.'" value="" placeholder="Review Here." rows="5" cols="50"></textarea></td>
								</tr>
								<tr>
									<td></td><td><input type="button" onclick="formSubmit('.$count.')" value="send" /></td>
								</tr>
							</table>
                                                        <input type="hidden" name="content_id" value="'.$temp.'">
						</form>
					</div>
				</div>
				<div class="clearer"></div>
				<hr class="line" />';
    echo '</div>';
    $count ++;
    //echo $temp['review'].'<br>'.$temp['name'];
    //echo "check";

}
?>
		</div>
	</body>
</html>