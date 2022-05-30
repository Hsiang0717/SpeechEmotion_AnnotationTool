<!DOCTYPE html>
<html>
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport">
	<link href="styles.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
	<link href="./icon/emotion.ico" rel="icon" type="image/x-icon">
	<title>語音情緒標記工具</title>
	<script src="https://unpkg.com/wavesurfer.js" type="text/javascript">
	</script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js">
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js">
	</script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js">
	</script>
	<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js">
	</script>
	<script src="AudioPlayer.js" type="text/javascript">
	</script><!-- This following line is optional. Only necessary if you use the option css3:false and you want to use other easing effects rather than "linear", "swing" or "easeInOutCubic". -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.5/vendors/jquery.easings.min.jss">
	</script><!-- This following line is only necessary in the case of using the option `scrollOverflow:true` -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.5/vendors/scrolloverflow.min.js">
	</script><!-- fullPage.js v2.9.5 -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.5/jquery.fullpage.min.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.5/jquery.fullpage.js">
	</script>
</head>
<body onload="voice = new StartVoice();EventClick();">
	<!-- Modal -->
	<div aria-hidden="true" aria-labelledby="exampleModalCenterTitle" class="modal fade" data-backdrop="static" data-keyboard="false" id="exampleModalCenter" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">測試人員登記</h5>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="col-form-label" for="message-text">請輸入測試人員代碼!</label> 
						<form>                                             
							<input class="form-control" id="testPerson" type="password">
						</form>
						<p class="text-danger" id="errorMessage" style="text-align:center"></p>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" id="login" type="button">登入</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	<!-- 自動彈出視窗 -->
	           if("<?php echo @$_COOKIE["UserName"]; ?>" === ""){
	               //http://alfredwebdesign.blogspot.com/2013/05/php-notice-undefined-index.html
	               $(document).ready(function(){
	                   $("#exampleModalCenter").modal('show');
	                   $('#login').click(function(){
	                       $.post("userCheck.php",
	                       {
	                         pass: $("#testPerson").val()
	                       },
	                       function(data,status){
	                           //let userdata = JSON.parse(data)
	                           //alert("Data: " + data + "\nStatus: " + status);
	                           //console.log(userdata.information);
	                           if( $("#testPerson").val() == data && $("#testPerson").val() != ""){
	                               $("#exampleModalCenter").modal('hide');
	                               //voice.data_init(userdata.information);
	                               voice.nextVoice();
	                               location.reload();
	                           }else{
	                               $("#errorMessage").text("輸入錯誤!!");
	                               $("#testPerson").val("");
	                           }
	                       });                 
	                   }); 
	               });
	           }
	</script>
	<div id="PageSelect">
		<div class="section">
			<center>
				<nav class="fixed-top justify-content-center navbar navbar-dark bg-dark navbar-expand-sm" style="background-color: #e3f2fd;">
					<ul class="navbar-nav">
						<li class="nav-item active">
							<a class="navbar-brand navbar-brand bg-dark text-white font-weight-bold" href="#">
							<h3><strong>語音情緒標記工具</strong></h3></a> <span class="navbar-text bg-dark text-white" id="subTitle">字幕</span> <input data-offstyle="dark" data-onstyle="success" data-size="xs" data-toggle="toggle" disabled id="toggle-state" type="checkbox">
						</li>
					</ul>
				</nav>
				<div class="container">
					<div class="alert alert-success alert-dismissible fade" id="myAlert" style="display:none;">
						<p id="notice"></p>
					</div>
				</div>				
				<div id="waveform" style="pointer-events: none; display:none;"></div><!-- 聲音片段 -->
				<div>
					<h6><p class="font-weight-bold text-dark" id="Prevsubtitle" style="visibility:hidden;"></p></h6>
				</div><!-- 字幕 -->
				<div>
					<h3><p class="font-weight-bold text-primary" id="Nowsubtitle" style="visibility:hidden;"></p></h3>
				</div><!-- 字幕 -->
				<div>
					<h6><p class="font-weight-bold text-dark" id="Nextsubtitle" style="visibility:hidden;"></p></h6>
				</div><!-- 字幕 -->
				<div class="container" id="buttonShow" style="text-align:center; pointer-events: none; margin-bottom:80px;">
					<div class="row">
						<div class="col-4 py-4 col-md-2 bg-light">
							<button class="btn btn-success btn-lg" onclick="voice.getEmotion(this.value);" type="button" value="1">快樂</button>
						</div>
						<div class="col-4 py-4 col-md-2 bg-light">
							<button class=" btn btn-secondary btn-lg" onclick="voice.getEmotion(this.value);" type="button" value="2">傷心</button>
						</div>
						<div class="col-4 py-4 col-md-2 bg-light">
							<button class="btn btn-primary btn-lg" onclick="voice.getEmotion(this.value);" type="button" value="3">害怕</button>
						</div>
						<div class="col-4 py-4 col-md-2 bg-light">
							<button class="btn btn-danger btn-lg" onclick="voice.getEmotion(this.value);" type="button" value="4">生氣</button>
						</div>
						<div class="col-4 py-4 col-md-2 bg-light">
							<button class="btn btn-warning btn-lg" onclick="voice.getEmotion(this.value);" type="button" value="5">驚訝</button>
						</div>
						<div class="col-4 py-4 col-md-2 bg-light">
							<button class="btn btn-dark btn-lg" onclick="voice.getEmotion(this.value);" type="button" value="6">厭惡</button>
						</div>
						<div class="col-6 py-4 col-md-6 bg-light">
							<button class="btn btn-outline-info btn-lg" onclick="voice.getEmotion(this.value);" type="button" value="7">平淡</button>
						</div>
						<div class="col-6 py-4 col-md-6 bg-light" style="text-align:left;">
							<!--<button type="button" class="btn btn-outline-dark btn-lg" value="8" onclick="voice.getEmotion(this.value);">跳過</button>-->
							<div class="form-check form-check-inline custom-checkbox checkbox-lg">
								<input class="form-check-input" id="inlineCheckbox1" name="remarkCH" style="zoom:180%;" type="checkbox" value="1"> <label class="form-check-label" for="inlineCheckbox1">不確定</label>
							</div>
							<div class="form-check form-check-inline custom-checkbox checkbox-xl">
								<input class="form-check-input" id="inlineCheckbox2" name="remarkCH" style="zoom:180%;" type="checkbox" value="2"> <label class="form-check-label" for="inlineCheckbox2">非『語句』</label>
							</div>
						</div>
					</div>
				</div>
			<nav class="navbar fixed-bottom navbar-dark bg-dark">
				<div class="text-white col" style="text-align:left">
					<a class="text-white" href="logOut.php"><?php echo @$_COOKIE["UserName"];?></a>
				</div>
				<div class="col-6" style="text-align:center">
					<div class="btn-group">
						<!--<button id="btnStop" class="btn btn-success btn-lg" ><i class="fa fa-undo"></i></button>-->
						<button id="btnBackward" style="visibility:hidden;" class="btn btn-success btn-lg" ><i class="fa fa-backward"></i></button>
						<button class="btn btn-success btn-lg" id="btnPlay"><i class="fa fa-play" id="voicestatus"></i></button> <!-- <button id="btnNext" class="btn btn-success btn-lg" ><i class="fa fa-step-forward"></i></button> -->
					</div>
				</div>
				<div class="text-white col" style="text-align:right">
					<a class="text-white" href="#" id="NowVoice"></a>
				</div>
			</nav>
		</center>
		</div>
		<div class="section"> <!--fp-auto-height https://mnya.tw/cc/word/1402.html-->
			<div id="search_result"></div>
			<label for="usr">Emotion Label Search:</label>
			<div class="input-group mb-4">
				<input type="text" class="form-control" id="usr">
				<div class="input-group-append">
					<button class="btn" id="clear_ELS"><i class="fa fa-undo"></i></button>
				</div>
			</div>
			<script>
				$(document).ready(function () {

					load_data();
					
					$('#clear_ELS').click(function(){
						$("#usr").val("");
						load_data();
					});
					
					function load_data(query) {
						$.ajax({
							url: "EmotionLabelSearch.php",
							method: "GET",
							data: {
								s: query
							},
							success: function (data) {
								$('#search_result').html(data);
							}
						});
					}
					$('#usr').keyup(function () {
						var search = $(this).val();
						if (search != '') {
							load_data(search);
						} else {
							load_data();
						}
					});
				});
			</script>
		</div>
	</div>
	<script>
	   $( "#PageSelect" ).fullpage({
	       // 參數設定[註1]https://ithelp.ithome.com.tw/articles/10197764
	       navigation: false, // 顯示導行列
	       navigationPosition: "right", // 導行列位置
		   
	   });
	</script>
</body>
</html>
<!--https://www.itread01.com/content/1543255982.html-->