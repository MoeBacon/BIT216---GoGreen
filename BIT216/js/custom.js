(function ($) {
    "use strict";
    var script = {};
    var $window = $(window),
      $document = $(document),
      $body = $('body');
    $.fn.exists = function () {
      return this.length > 0;
    };
    
    script.isSticky = function () {
        $(window).on('scroll',function(event) {
              var scroll = $(window).scrollTop();
              if (scroll < 300) {
                  $(".header").removeClass("sticky-top");
              }else{
                  $(".header").addClass("sticky-top");
              }
          });
      };

    script.carousel = function () {
      var owlslider = jQuery("div.owl-carousel");
      if (owlslider.length > 0) {
        owlslider.each(function () {
          var $this = $(this),
            $items = ($this.data('items')) ? $this.data('items') : 1,
            $loop = ($this.attr('data-loop')) ? $this.data('loop') : true,
            $navdots = ($this.data('nav-dots')) ? $this.data('nav-dots') : false,
            $navarrow = ($this.data('nav-arrow')) ? $this.data('nav-arrow') : false,
            $autoplay = ($this.attr('data-autoplay')) ? $this.data('autoplay') : true,
            $autospeed = ($this.attr('data-autospeed')) ? $this.data('autospeed') : 5000,
            $smartspeed = ($this.attr('data-smartspeed')) ? $this.data('smartspeed') : 1000,
            $autohgt = ($this.data('autoheight')) ? $this.data('autoheight') : false,
            $space = ($this.attr('data-space')) ? $this.data('space') : 30,
            $animateOut = ($this.attr('data-animateOut')) ? $this.data('animateOut') : false;
  
          $(this).owlCarousel({
            loop: $loop,
            items: $items,
            responsive: {
              0: {
                items: $this.data('xx-items') ? $this.data('xx-items') : 1
              },
              480: {
                items: $this.data('xs-items') ? $this.data('xs-items') : 1
              },
              768: {
                items: $this.data('sm-items') ? $this.data('sm-items') : 2
              },
              980: {
                items: $this.data('md-items') ? $this.data('md-items') : 3
              },
              1200: {
                items: $items
              }
            },
            dots: $navdots,
            autoplayTimeout: $autospeed,
            smartSpeed: $smartspeed,
            autoHeight: $autohgt,
            margin: $space,
            nav: $navarrow,
            navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
            autoplay: $autoplay,
            autoplayHoverPause: true
          });
        });
      }
    }
  
  script.swiperAnimation = function () {
    var siperslider = jQuery(".swiper-container");
    if (siperslider.length > 0) {
      var swiperAnimation = new SwiperAnimation();
          var swiper = new Swiper(".swiper-container", {
            init : true,
            direction: "horizontal",
            effect: "slide",
            loop: true,
  
            keyboard: {
              enabled: true,
              onlyInViewport: true
            },
              // Navigation arrows
              navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
              },
            on: {
              init: function() {
                swiperAnimation.init(this).animate();
              },
              slideChange: function() {
  
                swiperAnimation.init(this).animate();
              }
            }
          });
      }
    }
  
    $document.ready(function () {
        script.isSticky(),
        script.carousel(),
        script.swiperAnimation()
    });
  
  })(jQuery);
  
  function databgcolor() {
      $('[data-bg-color]').each(function(index, el) {
       $(el).css('background-color', $(el).data('bg-color'));  
      });
      $('[data-text-color]').each(function(index, el) {
       $(el).css('color', $(el).data('text-color'));  
      });
      $('[data-bg-img]').each(function() {
       $(this).css('background-image', 'url(' + $(this).data("bg-img") + ')');
      });
  };
  
  function validatePassword() {
      var password = document.getElementById("form_password").value;
      var confirmPassword = document.getElementById("form_password1").value;
  
      if (password !== confirmPassword) {
          alert("Passwords do not match");
          return false; // Prevent form submission
      } else {
          if (password.length < 8) {
              alert("Your password must be at least 8 characters.");
              return false; // Prevent form submission
          }
          else{
              return true;
          }
      }
  }