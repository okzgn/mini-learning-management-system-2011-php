/*
	doc.[uSER iNTERFACE].js/
	2011 (c) AdminUCE. by OKZGN
*/

function Hover(obj, classname){ obj.bind('mouseover', function(){ $(this).addClass(classname); }); obj.bind('mouseout', function(){ $(this).removeClass(classname); })}
function Focus(obj, classname){ obj.bind('focus', function(){ $(this).addClass(classname); }); obj.bind('blur', function(){ $(this).removeClass(classname); })}

$(window).bind('load', function(){

	var TextInputs = $('.s-frm-text');
	var FormButtons = $('.s-frm-button');
	var TextAreas = $('.s-frm-textarea');

	Hover(TextInputs, 's-frm-text-hover');
	Focus(TextInputs, 's-frm-text-focus');
	Hover(FormButtons, 's-frm-button-hover');

	Hover(TextAreas, 's-frm-textarea-hover');
	Focus(TextAreas, 's-frm-textarea-focus');

	if(TextInputs) TextInputs.bind("keydown", function(){ $(this).val($(this).val().slice(0, 255)); });
	if(TextAreas) TextAreas.bind("keydown", function(){ $(this).val($(this).val().slice(0, 1024)); });


	if(Helpys = $('a.helpy')){
		var helpboxes = $('.helpbox');
		Helpys.each(function(i){
			var pos = $(this).offset(), wid = ($(this).width() * 2) + 2, target = $(helpboxes[i]);
			$(this).hover(function(){
				target.css('top', pos.top);
				target.css('left', pos.left + wid);
				target.css('display', 'block');
			},
			function(){
				target.css('display', 'none');
			});
		});
	}

	if(Fimags = $('.fimag')) Fimags.fancybox();

	if(TextInputs[0]) TextInputs[0].focus();
	if(Tigtened = $('.tigtened .s-frm-text')){
		Tigtened.focus();
		Tigtened.select();
	}

	$('.npoint input[type="text"]').bind('change', function(){
      var inputNota = $(this);
      var archivo = inputNota.prev('input[type="hidden"]').val();
      var nota = inputNota.val();

      $.post('putp.php', { file: archivo, point: nota }, function(res){
          inputNota.css('background-color', '#cfc');
      });
  });

});
