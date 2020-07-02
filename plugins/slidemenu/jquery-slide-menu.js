  // Product by webproducer.ir@gmail.com
  
  (function ($) {
      var OCMenu = function (element, speed, expand) {
          element.html('<i class="fa fa-edit fa-lg "></i>');
  
          if (typeof expand != 'undefined') {
              element.data('expand', expand);
          } else {
              element.data('expand', element.data('expand') ? false : true);
          }
  
          if (element.data('expand')) {
              element.parent().animate({ 'right': '-5px' }, {
                  duration: speed,
                  start: function () {
                      
                  }
              });
          } else {
              element.parent().animate({ 'right': '-287px' }, {
                  duration: speed,
                  start: function () {
                      
                  }
              });
          }
      }
  
      var slideToggleUD = function (element, speed, isUp) {
          element.siblings('.body-slide').animate({
              display: 'block',
              height: isUp ? 'hide' : 'show'
          }, {
              duration: speed,
              start: function () {
                  var title = element.text();
                  var icon = isUp ? 'fa-plus-square' : 'fa-minus-square';
                  element.html('<i class="fa ' + icon + '"></i> ' + title);
              }
          });
      }
	  
  
      var collapse = function (element, elements, data, speed) {
          if (!data) {
              if (!element.data('collapse')) {
                  slideToggleUD(element, speed, true);
              } else {
                  slideToggleUD(element, speed, false);
              }
              element.data('collapse', element.data('collapse') ? false : true);
          } else {
              if (element.data('collapse')) {
                  slideToggleUD(element, speed, true);
              } else {
                  elements.each(function () {
                      if ($(this).data('index') != element.data('index')) {
                          slideToggleUD($(this), speed, true);
                          $(this).data('collapse', false);
                      }
                  });
                  slideToggleUD(element, speed, false);
              }
              element.data('collapse', element.data('collapse') ? false : true);
          }
      }
  
      var collapsed = function (element, data) {
          if (data) {
              if (element.data('index') == 0) {
                  slideToggleUD(element, 100, false);
                  element.data('collapse', data);
              } else {
                  slideToggleUD(element, 100, true);
                  element.data('collapse', !data);
              }
          } else {
              if (element.data('index') == 0) {
                  slideToggleUD(element, 100, false);
                  element.data('collapse', data);
              } else {
                  slideToggleUD(element, 100, true);
                  element.data('collapse', !data);
              }
          }
      }
  
      $.fn.SlideMenu = function (settings) {
          var collection = this;
          var config = {
              speedLR: 500,
              speedUD: 500,
              expand: false,
              collapse: true
          };
  
          if (settings) { $.extend(config, settings); }
  
          return this.each(function () {
              var self = $(this);
              var elements = {
                  btnSlide: self.find('.btn-slide'),
                  headSlide: self.find('.head-slide')
              };
  
              elements.btnSlide.each(function () {
                  var $this = $(this);
  
                  OCMenu($this, config.speedLR, config.expand);
  
                  $this.click(function () { OCMenu($this, config.speedLR); });
              });
  
              elements.headSlide.each(function (index) {
                  var $this = $(this);
  
                  $this.data('index', index);
                  collapsed($this, config.collapse);
  
                  $this.click(function () {
                      collapse($this, elements.headSlide, config.collapse, config.speedUD);
                  });
              });
          });
      }
  
      $.fn.Modal = function (settings) {
          var config = {
          };
  
          if (settings) { $.extend(config, settings); }
      }
  })(jQuery);
