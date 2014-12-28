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

  $(".edit").one('click',onEdit);

  function onEdit(event){
    event.preventDefault();
    close();

    var $this = $(this),
      $parent = $this.parent(),
      $wrapper = $parent.find('.wrapper'),
      width = $wrapper.width()+2,
      height = $wrapper.height()+45;

    var $form = $('<form action="app/redigera.php" method="post">'),
      $area = $('<textarea name="content">').html($wrapper.html()),
      heightOffset = -103,
      cssPath = $('link[rel=stylesheet]').attr("href");

    $form.append($area);
    $form.css("margin-top", heightOffset + "px");
    $form.css("margin-left" , "-2px");

    $form.append($('<input type="hidden" name="file"/>').val($this.data('file')));
    $form.append($('<input type="hidden" name="aktivid"/>').val($this.data('active')));

    $wrapper.hide();
    $parent.append($form);

    $area.tinymce({
      script_url:"tinymce/tinymce.min.js",
      theme: "modern",
      width: width,
      height: height,
      document_base_url: '/',
      plugins: [
        "advlist autolink close link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
        "table contextmenu directionality emoticons paste textcolor responsivefilemanager save code template"
      ],
      toolbar1: "save close | undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | styleselect | responsivefilemanager | link unlink anchor | image media ",
      save_enablewhendirty: true,
      image_advtab: true ,
      external_filemanager_path:"/filemanager/",
      filemanager_title:"Responsive Filemanager" ,
      external_plugins: { "filemanager" : "/filemanager/plugin.min.js"},
      content_css : cssPath,
      style_formats_merge: true,
      style_formats: [
        {title: "Custom Blocks", items: [
          {title: "Panel", block: "div", classes : 'panel panel-default panel-body', wrapper : true },
          {title: "Panel ", block: "div", classes : 'theme-panel-plain', wrapper : true },
          {title: "Panel ", block: "div", classes : 'theme-panel-em', wrapper : true },
          {title: "Panel ", block: "div", classes : 'theme-panel-lighterblue', wrapper : true },
          {title: "Panel ", block: "div", classes : 'theme-panel-lightblue', wrapper : true },
          {title: "Panel ", block: "div", classes : 'theme-panel-middleblue', wrapper : true },
          {title: "Panel ", block: "div", classes : 'theme-panel-darkblue', wrapper : true },
          {title: "Panel ", block: "div", classes : 'theme-panel-green', wrapper : true },
          {title: "Panel ", block: "div", classes : 'theme-panel-orange', wrapper : true },
          {title: "Jumbotron", block: "div", classes : 'jumbotron', wrapper: true },
          {title: "Text Right", block: "div", classes : 'padding-small-left', wrapper: true },
          {title: "Text Left", block: "div", classes : 'padding-small-right', wrapper: true },
          {title: "Devide Right", block: "div", classes : 'half-right', wrapper: true },
          {title: "Devide Left", block: "div", classes : 'half-left', wrapper: true }
        ]},
        {title: "Custom Styles", items: [
          {title: "Font size 11", inline: "span", classes:  "t11" },
          {title: "Font size 10", inline: "span", classes:  "t10" },
          {title: "Font size 9", inline: "span", classes:  "t9" },
          {title: "Font size 8", inline: "span", classes:  "t8" },
          {title: "Font size 7", inline: "span", classes:  "t7" },
          {title: "Font size 6", inline: "span", classes:  "t6" },
          {title: "Font size 5", inline: "span", classes:  "t5" },
          {title: "Font size 4", inline: "span", classes:  "t4" },
          {title: "Font size 3", inline: "span", classes:  "t3" },
          {title: "Font size 2", inline: "span", classes:  "t2" },
          {title: "Font size 1", inline: "span", classes:  "t1" }
        ]}
      ],
      templates: [
        {title: 'quote', description: 'Insert a guote on the site', url : 'app/mceTemplates/quote.html'},
        {title: 'imgFigure', description: 'Insert a image placeholder for img and img caption', url: 'app/mceTemplates/figure.html'},
        {title: 'panel', description: 'Insert a panel placeholder', url: 'app/mceTemplates/panel.html'}
      ]
    });
    return false;
  }

  function close(){
    $('.mce-tinymce').parent().remove();
    $('.wrapper').show();
    $(".edit").one('click',onEdit);
  }
});

function loadPlugins(editor){
  closePlugin(editor)
}

function closePlugin(editor, url) {
  // Add a button that opens a window
  console.log("Load editor");
  editor.addButton('close', {
    text: 'close',
    icon: false,
    onclick: function() {
      console.log("CLOSE EDITOR");
    }
  });

  // Adds a menu item to the tools menu
  editor.addMenuItem('close', {
    text: 'Close',
    context: 'tools',
    onclick: function() {
      console.log("CLOSE EDITOR");
    }
  });
}


