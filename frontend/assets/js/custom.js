$(document).ready(function() {

 $("main#spapp > section").height($(document).height() - 60);
 

  var app = $.spapp({
    defaultView  : "#about",
    templateDir  : "./tpl/",
    pageNotFound : "#404"
  }); // initialize

  // define routes

  app.route({
    view : "404",
    load : "404.html",
    onReady: function() {
      $("section").hide();
      $("#404").show();
      window.scrollTo(0,0);
      }
  });

  app.route({
    view : "about",
    load : "about.html",
    onReady: function() {
      $("section").hide();
      $("#about").show();
      window.scrollTo(0,0);
      }
  });

  app.route({
    view : "adminpanel",
    load : "adminpanel.html",
    onReady: function() {
      $("section").hide();
      $("#adminpanel").show();
      window.scrollTo(0,0);
      }
  });


  app.route({
    view : "package",
    load : "package.html",
    onReady: function() {
      $("section").hide();
      $("#package").show();
      window.scrollTo(0,0);
      }
  });

  app.route({
    view : "viewmore",
    load : "viewmore.html",
    onReady: function() {
      $("section").hide();
      $("#viewmore").show();
      window.scrollTo(0,0);
      }
  });

  // run app
  app.run();

});