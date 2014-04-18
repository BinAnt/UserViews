$(document).ready(function(){
	$("a#create").on('click',function(event){
		event.preventDefault();
		var html = '';
		$.post("userview/add",null,function(data){
			if(data.response == true){
                    $("div#userview").attr('class','shadow');
                    html = "<div id=\"addone\">";
                    html +=		"<div class=\"one\">";
					html += 		"<input class='id' type=\"hidden\" name=\"id\" value="+data.new_user_id+">";
					html +=		"</div>";
					html +=		"<div class=\"one\">";
					html +=			"<label for=\"name\">name:</label>";
					html += 		"<input class='name' type=\"text\" name=\"name\">";
					html +=		"</div>";
					html +=		"<div class=\"one\">";
					html +=			"<label for=\"password\">password:</label>";
					html +=			"<input type=\"password\" name=\"password\" class='pwd'>";
					html +=		"</div>";
					html +=		"<div class=\"one\">";
					html +=			"<input type=\"submit\" id=\"btn\" value=\"OK\">"
					html +=	"</div>";
					html +=	"</div>";
                    $("div#userview").append(html);
                } else {
                    // print error message
                    console.log('could not add');
                }
            }, 'json');
		});

	$("div#userview").on('focus',"input.name",function(event){
		$("span.warn").html('');
	});
	$("div#userview").on('focus',"input.pwd",function(event){
		$("span.warn").html('');
	});
	$("div#userview").on('blur',"input.name",function(event){
		var name = $('input.name').val();
		$.post('userview/checkname',{'user':name},function(data){
			if(data.response==true){
			 return true;
			}else{
				$('input.name').after("<span class=\"warn\">该用户名已存在</span>");
			}
		},'json');
	});

	$("div#userview").on('blur',"input.pwd",function(event){
		var pwd = $('input.pwd').val();
		if(jQuery.trim(pwd)!=''){
			pwd = jQuery.trim(pwd);
			if(pwd.length < 6 || pwd.length > 16){
				$('input.pwd').after("<span class=\"warn\">请输入6-16位密码</span>");
			}
		}else{
			$('input.pwd').after("<span class=\"warn\">请输入6-16位密码</span>");
		}
	});

	$("body").on('click',"#btn",function(event){
		var name = $('input.name').val();
		var pwd = $('input.pwd').val();
		var id = $('input.id').val();
		$.post('userview/update',{
			'id':id,
			'name':name,
			'password':pwd,
		},function(data){
			if(data.response == true){
				location.href = "./";
			}else{
				$("div#userview").append("<span style=\"color:red;\">添加失败</span>");
			}
		},'json');
	});

	$("#userview").on('click','a.delete-view',function(event){
		event.preventDefault();
		var $userview = $(this);
		var remove_id = $(this).attr('id');
		remove_id = remove_id.replace("remove-","");
		$.post('userview/remove',{
			id:remove_id
			},function(data){
				if(data.response == true){
					//$userview.parent().remove();
					location.href = "./";
				}else{
					 console.log('could not remove ');
				}
		},'json');
	});
});