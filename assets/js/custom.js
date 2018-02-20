//@prepros-prepend libs/bootstrap.min.js
//@prepros-prepend easing.js
//@prepros-prepend libs/jquery-ui.min.js
//@prepros-prepend libs/slick.min.js


$('.selectpicker').selectpicker({
  
});


 $( "#accordion" ).accordion({
   heightStyle: "content",
	  active: false,
	  collapsible: true,   
 });

  $(function() {
    $('#options-bar').matchHeight({
          target: $('#main-content ')
      });
  });


  $(function() {
    $('#main-navigation').matchHeight({
          target: $('#main-content ')
      });
  });

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});




$(document).ready(function() {
    $('#open-side-menu').click(function() {
        $('#profile-menu').addClass('active-menu');
    });
});


$(document).ready(function() {
    $('.close-profile-menu').click(function() {
        $('#profile-menu').removeClass('active-menu');
    });
});

$(document).ready(function() {
    $('#close-option-bar').click(function() {
        $('#options-bar').toggleClass('active-option');
    });
});

$(document).ready(function() {
    $('#close-option-bar').click(function() {
        $('#main-content').toggleClass('active-content');
        $(this).toggleClass('active-close-btn');
    });
});

  $(document).ready( function() {
    $('#accordion-form').accordion({
        collapsible:true,
          heightStyle: "content" ,
        beforeActivate: function(event, ui) {
             // The accordion believes a panel is being opened
            if (ui.newHeader[0]) {
                var currHeader  = ui.newHeader;
                var currContent = currHeader.next('.ui-accordion-content');
             // The accordion believes a panel is being closed
            } else {
                var currHeader  = ui.oldHeader;
                var currContent = currHeader.next('.ui-accordion-content');
            }
             // Since we've changed the default behavior, this detects the actual status
            var isPanelSelected = currHeader.attr('aria-selected') == 'true';
            
             // Toggle the panel's header
            currHeader.toggleClass('ui-corner-all',isPanelSelected).toggleClass('ui-accordion-header-active ui-state-active ui-corner-top',!isPanelSelected).attr('aria-selected',((!isPanelSelected).toString()));
            
            // Toggle the panel's icon
            currHeader.children('.ui-icon').toggleClass('ui-icon-triangle-1-e',isPanelSelected).toggleClass('ui-icon-triangle-1-s',!isPanelSelected);
            
             // Toggle the panel's content
            currContent.toggleClass('accordion-content-active',!isPanelSelected)    
            if (isPanelSelected) { currContent.slideUp(); }  else { currContent.slideDown(); }

            return false; // Cancels the default action
        }
    });
});