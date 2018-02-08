/////////////////////////////////////////////////////

//					web·唐明明 			           //

/////////////////////////////////////////////////////

/*

$(document).ready(function() {
	if (window.DeviceMotionEvent){
		var speed = 25;
		var audio = document.getElementById("shakemusic");
		var openAudio = document.getElementById("openmusic");
		var x = t = z = lastX = lastY = lastZ = 0;
		window.addEventListener('devicemotion',
			function () {
				var acceleration = event.accelerationIncludingGravity;

				x = acceleration.x;
				y = acceleration.y;
				if (Math.abs(x - lastX) > speed || Math.abs(y - lastY) > speed) {
					audio.play();
					$('.red-ss').addClass('wobble')
					setTimeout(function(){
						audio.pause();
						openAudio.play();
						$('.red-tc').css('display', 'block');
						$('.red-yzj').css('display', 'block');
						$('.red-wzj').css('display', 'none');
						$('.red-nc-chance').css('display', 'none');
					}, 1500);
				};
				lastX = x;
				lastY = y;
			},false);
	};
	$()
});


*/
var SHAKE_THRESHOLD = 3000;
var last_update = 0;
var x = y = z = last_x = last_y = last_z = 0;
var num = 0;
var isprint = false;
function send() {
    if(checkTime('2017-12-18 16:55', '2018-1-12 23:59', new Date().format("yyyy-MM-dd hh:mm:ss"))) {
        $.ajax({
            url: "datasave.php", data: {name: $('#name').val(), time: num}, success: function (s) {
                // alert(s);
            }
        });
        num=0;

    } else {
        num=0;
    }
}

function init() {
    if (window.DeviceMotionEvent) {
        window.addEventListener('devicemotion', deviceMotionHandler, false);
    } else {
        alert('not support mobile event');
    }
}

function deviceMotionHandler(eventData) {
    var acceleration = eventData.accelerationIncludingGravity;
    var curTime = new Date().getTime();
    if ((curTime - last_update) > 100) {
        var diffTime = curTime - last_update;
        last_update = curTime;
        x = acceleration.x;
        y = acceleration.y;
        z = acceleration.z;
        var speed = Math.abs(x + y + z - last_x - last_y - last_z) / diffTime * 10000;

        /*if (speed < SHAKE_THRESHOLD) {
            num++;
            var node = document.getElementById("text");
            node.innerHTML=num+"times";

            num==0;
        }
        */
        var x1 = Math.abs(x - last_x);
        var y1 = Math.abs(y - last_y);
        var z1 = Math.abs(z - last_z);
        var max = 0;
        if (x1 > y1) {
            if (x1 > z1) {
                max = x1;
            } else {
                max = z1;
            }
        } else {
            if (y1 > z1) {
                max = y1;
            } else {
                max = z1;
            }
        }
        if (max > 40) {
            isprint = true;
            num++;
        } else if (max < 5 && isprint) {
            // var node = document.getElementById("ulid");
            // var li=document.createElement("li");
            // li.innerText=num;
            // node.appendChild(li);
            // num=0


            isprint = false;
        }
        last_x = x;
        last_y = y;
        last_z = z;
    }
}

function checkTime(stime, etime, time) {
    var timestampS = (new Date(stime)).valueOf();
    var timestampE = (new Date(etime)).valueOf();
    var timestampT = (new Date(time)).valueOf();
    if (timestampT >= timestampS && timestampT <= timestampE) {
        return true;
    } else {
        return false;
    }
}

Date.prototype.format = function (format) {
    var o = {
        "M+": this.getMonth() + 1, //month
        "d+": this.getDate(), //day
        "h+": this.getHours(), //hour
        "m+": this.getMinutes(), //minute
        "s+": this.getSeconds(), //second
        "q+": Math.floor((this.getMonth() + 3) / 3), //quarter
        "S": this.getMilliseconds() //millisecond
    }
    if (/(y+)/.test(format)) format = format.replace(RegExp.$1,
        (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o) if (new RegExp("(" + k + ")").test(format))
        format = format.replace(RegExp.$1,
            RegExp.$1.length == 1 ? o[k] :
                ("00" + o[k]).substr(("" + o[k]).length));
    return format;
}

//用法：
var timebool = checkTime('2017-12-18 16:55', '2017-12-20 17:59', new Date().format("yyyy-MM-dd hh:mm:ss"));//注意：日期用“-”分隔
window.setInterval("send()", 200);
