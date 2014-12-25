$(document).ready(function(){

  var menuLinks = $('#menu ul li a');
  for (var i=0 ;menuLinks.length > i; i++){
    link = menuLinks[i];
    if (window.location.pathname == link.pathname){
      $(link).parent().addClass('active');
    }
  }
});

$(document).ready(function(){

  $(".edit").on('click', function(event){
    event.preventDefault();
    $self = $(this).parent().find('.wrapper');

    var width = $self.width(),
      height = $self.height();

    var $form = $('<form action="app/redigera.php" method="post">'),
      $area = $('<textarea>').html($self.html());

    $form.append($area);
    $form.append($('<input type="hidden" name="file"/>').val($self.attr('data-file')));
    $form.append($('<input type="hidden" name="aktivid"/>').val($self.attr('data-activeId')));

    $self.replaceWith($form);
    $area.tinymce({
      script_url:"tinymce/tinymce.min.js",
      theme: "modern",
      width: width,
      height: height,
      document_base_url: '/',
      plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
        "table contextmenu directionality emoticons paste textcolor responsivefilemanager save code template"
      ],
      toolbar1: "save | undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
      toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor | print preview",
      save_enablewhendirty: true,
      image_advtab: true ,
      external_filemanager_path:"/filemanager/",
      filemanager_title:"Responsive Filemanager" ,
      external_plugins: { "filemanager" : "/filemanager/plugin.min.js"},
      content_css : "/app/css/main.css",
      templates: [
        {title: 'quote', description: 'Insert a guote on the site', url : 'app/mceTemplates/quote.html'},
        {title: 'imgFigure', description: 'Insert a image placeholder for img and img caption', url: 'app/mceTemplates/figure.html'}
      ]
    });
    return false;
  })
});

