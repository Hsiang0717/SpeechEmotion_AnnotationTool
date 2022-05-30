var voice;
var wavesurfer;
var inf;
class StartVoice{
    constructor(){
		 wavesurfer = WaveSurfer.create({
						container: '#waveform',
						waveColor: 'gray',
						progressColor: 'blue'
					});
					 wavesurfer.on('finish',function(){
						document.getElementById('btnPlay').disabled=true;
						document.getElementById("voicestatus").className = "fa fa-play";
						setTimeout(function(){ 
							document.getElementById("buttonShow").style.visibility="visible";
							document.getElementById('btnPlay').disabled=false;
						}, 3000);		
					 });			 
		 this.nextVoice();
    }
	/*data_init(data){
		 //https://wcc723.github.io/javascript/2017/06/29/es6-native-array/
		 let inf = JSON.parse(data);
		 //console.log(inf.Scope[0].SentenceID);
		 this.nextVoice(inf.Scope[0].SentenceID);
		 
	}*/	
	nextVoice(){
		let xmlhttp = new XMLHttpRequest();
		xmlhttp.open("POST", "nextVoice.php", true);
		xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=UTF-8');
		//xmlhttp.send("q="+str);
		xmlhttp.send();
		xmlhttp.onload = function(){
			inf = JSON.parse(this.responseText);
			console.log(inf);
			if(inf.Now == 0) document.getElementById("btnBackward").style.visibility="hidden";
			if(inf.voiceID != ""){
				 document.getElementById("NowVoice").innerHTML = "EP 0"+inf.EpisodeID+"\n"+(inf.Now+1)+"/"+inf.All;
				 document.getElementById("Prevsubtitle").innerHTML = inf.Prevsentence;
				 document.getElementById("Nowsubtitle").innerHTML = inf.Nowsentence;
				 document.getElementById("Nextsubtitle").innerHTML = inf.Nextsentence;			 
				 wavesurfer.load('./wav/'+ inf.voiceID +'.wav');
				 if(inf.Status =="text"){
					 wavesurfer.setMute(true);//靜音
				 }
				 SubtitleChecked(inf.Status);
			}else{
				 document.getElementById("Prevsubtitle").style.visibility="hidden";
				 document.getElementById("Nowsubtitle").style.visibility="hidden";
				 document.getElementById("Nextsubtitle").style.visibility="hidden";
				 document.getElementById("buttonShow").style.visibility="hidden";
				 document.getElementById("myAlert").style.display="";
				 document.getElementById("myAlert").classList.add("show");
				 document.getElementById("notice").innerHTML="<strong>感謝您!!</strong><br>已經協助標記完全部資料 : )。";
				 document.getElementById('btnPlay').disabled=true;
				 document.getElementById("voicestatus").className = "fa fa-play";
			}

		}
	}
	getEmotion(emo){
		document.getElementById("buttonShow").style.pointerEvents ="none";
		//https://www.fooish.com/javascript/date/
		
		var today=new Date();

		var currentDateTime = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+' '+today.getHours()+':'+today.getMinutes()+':'+today.getSeconds();
		//console.log(currentDateTime);
		
		var remarkCH = document.getElementsByName("remarkCH");
		var remark=0;
		for(let i = 0 ; i<remarkCH.length ; i++){
			if (remarkCH[i].checked == true){	
				remark += parseInt(remarkCH[i].value, 10);
			}
		}
		
		console.log(remark);
		
		let xmlhttp = new XMLHttpRequest();
		xmlhttp.open("POST", "uploadEmo.php", true);
		xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=UTF-8');
		xmlhttp.send("SentenceID="+inf.voiceID+"&emotion="+emo+"&MarkTime="+currentDateTime+
			"&Num="+inf.Now+"&Ep="+inf.EpisodeID+"&Remark="+remark+"&SaveKey="+inf.SaveKey+"&Status="+inf.Status);
		xmlhttp.onload = function(){
			 console.log(this.responseText);
			 if(this.responseText == "null"){
				 window.location = "logOut.php"
			 }else{
				 document.getElementById("notice").innerHTML="<strong>提交成功!</strong> 本訊息將會自動關閉。";
				 document.getElementById("myAlert").style.display="";
				 document.getElementById("myAlert").classList.add("show");
				 setTimeout(function(){				 
						 document.getElementById("myAlert").classList.remove("show");
						 document.getElementById("myAlert").style.display="none";
				 }, 1500);
				 voice.nextVoice();
			 }

		}
		document.getElementById("inlineCheckbox1").checked=false;
		document.getElementById("inlineCheckbox2").checked=false;
		document.getElementById("btnBackward").style.visibility="";
	}
	
	BackToPrevious(){
		
		document.getElementById("buttonShow").style.pointerEvents ="none";
		
		let xmlhttp = new XMLHttpRequest();
		xmlhttp.open("POST", "back2Previous.php", true);
		xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=UTF-8');
		xmlhttp.send("SentenceID="+inf.voiceID+"&Num="+inf.Now+"&Ep="+inf.EpisodeID+"&SaveKey="+inf.SaveKey+"&Status="+inf.Status);
		xmlhttp.onload = function(){
			 console.log(this.responseText);
			 if(this.responseText == "null"){
				 window.location = "logOut.php"
			 }else{
				 document.getElementById("notice").innerHTML="<strong>已返回上一題</strong>。";
				 voice.nextVoice();				 
				 document.getElementById("myAlert").style.display="";
				 document.getElementById("myAlert").classList.add("show");
				 setTimeout(function(){				 
						 document.getElementById("myAlert").classList.remove("show");
						 document.getElementById("myAlert").style.display="none";
				 }, 1500);
			 }

		}
		document.getElementById("inlineCheckbox1").checked=false;
		document.getElementById("inlineCheckbox2").checked=false;
	}
}

function EventClick(){
		document.getElementById("btnPlay").addEventListener("click", function(){						
			wavesurfer.playPause();
			document.getElementById("btnBackward").style.visibility="hidden";
			document.getElementById("buttonShow").style.visibility="hidden";
			document.getElementById("buttonShow").style.pointerEvents ="";
			if(wavesurfer.isPlaying()){
				document.getElementById("voicestatus").className = "fa fa-pause";
			}else{
				document.getElementById("voicestatus").className = "fa fa-play";
			}
		});
		
		document.getElementById("btnBackward").addEventListener("click", function(){
			var backAns = confirm("確定要返回作答嗎?");
			if(backAns == true){
				document.getElementById("btnBackward").style.visibility="hidden";
				voice.BackToPrevious();
			}

		});
		
		document.getElementById("toggle-state").onchange = function() {//使用者端控制
				
			if(document.getElementById("toggle-state").checked){
				//voice.nextVoice(n);
				document.getElementById("Prevsubtitle").style.visibility="";
				document.getElementById("Nowsubtitle").style.visibility="";
				document.getElementById("Nextsubtitle").style.visibility="";
			}else{
				//document.getElementById("subtitle").innerHTML = "";
				document.getElementById("Prevsubtitle").style.visibility="hidden";
				document.getElementById("Nowsubtitle").style.visibility="hidden";
				document.getElementById("Nextsubtitle").style.visibility="hidden";
			}
		}
		/*document.getElementById("btnStop").addEventListener("click", function(){
			wavesurfer.stop();
			document.getElementById("voicestatus").className = "fa fa-play";
		});*/

		/*document.getElementById("btnNext").addEventListener("click", function(){
			voice.nextVoice();
			document.getElementById("voicestatus").className = "fa fa-play";
		});	*/	
}
function SubtitleChecked(str){//伺服器端控制
		if(str == "text"){
			document.getElementById("Prevsubtitle").style.visibility="";
			document.getElementById("Nowsubtitle").style.visibility="";
			document.getElementById("Nextsubtitle").style.visibility="";
		}else{
			document.getElementById("Prevsubtitle").style.visibility="hidden";
			document.getElementById("Nowsubtitle").style.visibility="hidden";
			document.getElementById("Nextsubtitle").style.visibility="hidden";
		}
}
//https://andy6804tw.github.io/2018/01/07/bootstrap-alert-componment/
//https://www.jianshu.com/p/3132e76989bd
//https://pjchender.blogspot.com/2016/07/javascript-es6classes.html