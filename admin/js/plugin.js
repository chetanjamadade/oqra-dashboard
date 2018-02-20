        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        });

        $('input,textarea').focus(function(){
   $(this).data('placeholder',$(this).attr('placeholder'))
   $(this).attr('placeholder','');
});
$('input,textarea').blur(function(){
   $(this).attr('placeholder',$(this).data('placeholder'));
});

          $(document).ready(function(){
            var callbacks_list = $('.demo-callbacks ul');
            $('.demo-list input').on('ifCreated ifClicked ifChanged ifChecked ifUnchecked ifDisabled ifEnabled ifDestroyed', function(event){
              callbacks_list.prepend('<li><span>#' + this.id + '</span> is ' + event.type.replace('if', '').toLowerCase() + '</li>');
            }).iCheck({
              checkboxClass: 'icheckbox_square-blue',
              radioClass: 'iradio_square-blue',
              increaseArea: '20%'
            });
          });

$(function () {
  $('[data-toggle="popover"]').popover()
})

  

  $('[data-toggle="popover"]').popover({
  html: true,
  trigger: 'hover',
  content: function () {
    return '<img src="'+$(this).data('img') + '" />';
  }
});

