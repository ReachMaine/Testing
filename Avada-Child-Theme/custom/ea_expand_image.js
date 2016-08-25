jQuery(document).ready(function(){

	jQuery("img.ea-expandable").click(function(){
	jQuery(this).parent().toggleClass('ea-contracted-image');
	jQuery(this).parent().toggleClass('ea-expanded-image');
	});
});	