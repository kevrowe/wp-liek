;(function ($, window, undefined) {
  'use strict';

  var resizeTimeoutId = 0;
  var size = 'large';
  window.global = {};

  $.fn.absoluteHeight = function () {
    var keys = ['height', 'paddingTop', 'paddingBottom', 'marginTop', 'marginBottom'];
    var height = 0;

    for (var index in keys) {
      var val = parseInt($(this).css(keys[index]));
      if (!isNaN(val)) {
        height += val;
      }
    }

    return height;
  };

  $.fn.absoluteWidth = function () {
    var keys = ['width', 'paddingLeft', 'paddingRight', 'marginLeft', 'marginRight'];
    var width = 0;

    for (var index in keys) {
      var val = parseInt($(this).css(keys[index]));
      if (!isNaN(val)) {
        width += val;
      }
    }

    return width;
  };

  var $doc = $(document),
  Modernizr = window.Modernizr;

  $(document).ready(function() {
    $.fn.foundationAlerts           ? $doc.foundationAlerts() : null;
    $.fn.foundationButtons          ? $doc.foundationButtons() : null;
    $.fn.foundationAccordion        ? $doc.foundationAccordion() : null;
    $.fn.foundationNavigation       ? $doc.foundationNavigation() : null;
    $.fn.foundationTopBar           ? $doc.foundationTopBar() : null;
    $.fn.foundationCustomForms      ? $doc.foundationCustomForms() : null;
    $.fn.foundationMediaQueryViewer ? $doc.foundationMediaQueryViewer() : null;
    $.fn.foundationTabs             ? $doc.foundationTabs({callback : $.foundation.customForms.appendCustomMarkup}) : null;
    $.fn.foundationTooltips         ? $doc.foundationTooltips() : null;
    $.fn.foundationMagellan         ? $doc.foundationMagellan() : null;
    $.fn.foundationClearing         ? $doc.foundationClearing() : null;

    $.fn.placeholder                ? $('input, textarea').placeholder() : null;
  });

  $(window).load(initialise);

  // UNCOMMENT THE LINE YOU WANT BELOW IF YOU WANT IE8 SUPPORT AND ARE USING .block-grids
  // $('.block-grid.two-up>li:nth-child(2n+1)').css({clear: 'both'});
  // $('.block-grid.three-up>li:nth-child(3n+1)').css({clear: 'both'});
  // $('.block-grid.four-up>li:nth-child(4n+1)').css({clear: 'both'});
  // $('.block-grid.five-up>li:nth-child(5n+1)').css({clear: 'both'});

  // Hide address bar on mobile devices (except if #hash present, so we don't mess up deep linking).
  if (Modernizr.touch && !window.location.hash) {
    $(window).load(function () {
      setTimeout(function () {
        window.scrollTo(0, 1);
      }, 0);
    });
  }

  function initialise() {
    $('body').addClass('js');

    // Initialise carousels
    $('.carousel').each(function(){
      var width = $(this).find('li').first().width();

      $(this).bxSlider({
        slideWidth: width,
        minSlides: 1,
        maxSlides: $(this).data('bx-max-slides') || 5,
        slideMargin: $(this).data('bx-slide-margin') || 10,
        pager: $(this).data('bx-pager') || false
      });
    });

    $('.micro-nav').on('click', function() {
      $('.main-nav').slideToggle();
    });

    $(window).resize(resizeDelay);

    if ("orientationchange" in window) {
      $(window).on('orientationchange',resizeDelay);
    }

    initialiseMap();
    initialiseContactForm();
  }

  /**
   *  Contact Form
   */
   function initialiseContactForm() {
    var $form = $('.contact-form');
    if ($form.length == 0) {return;}

    function validateInput($elem) {
      if (typeof $elem.val() === 'undefined' || $elem.val().trim() === '') {
        $elem.parent().addClass('invalid');
        return false;
      } else {
        $elem.parent().removeClass('invalid');
        return true;
      }
    }

    function success (d,s) {
      if (d.responseText === 'success') {
        $form.slideUp(500);
        var $response = $('[data-contact-response]');

        $response.slideDown(500);
      } else {
        $form.prepend('<p>There was an error sending your message, please consider emailing us directly.</p>');
      }
    }

    $form.on('change', 'input, textarea', function() { validateInput($(this)); })

    $form.find('input[type=submit]').on('click', function(e) {
      e.preventDefault();

      var submitData = '&' + $(this).attr('name') + '=' + $(this).attr('value');
      var isValid = true;

      $form.find('[data-required]').each(function() {
        var fieldIsValid = validateInput($(this));
        isValid = !isValid ? false : fieldIsValid;
      });

      if (isValid) {
        $.ajax({
          url: $form.attr('action'),
          method: $form.attr('method'),
          data: $form.serialize() + submitData
        }).complete(success);
      }
    });
  }


  /**
   *  Map
   */
   function initialiseMap() {
    var mapElem = $('#areamap').first();
    if (mapElem.length == 0) {
      return;
    }

    global.gmapInit = function () {
      window.google.maps.visualRefresh = true;

      var map;

      var mapOptions = {
        zoom: 10,
        center: new google.maps.LatLng(51.4550131,-2.5865895),
        streetViewControl: false,
        zoomControl: false,
        panControl: false,
        scaleControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };

      map = new google.maps.Map(mapElem[0], mapOptions);

      // Define the LatLng coordinates for the polygon's path.
      var serviceAreaCoords = [];

      for (var i in ContactMapCoords) {
        serviceAreaCoords.push(new google.maps.LatLng(ContactMapCoords[i][0], ContactMapCoords[i][1]));
      }

      // Construct the polygon.
      var serviceArea = new google.maps.Polygon({
        paths: serviceAreaCoords,
        strokeColor: '#00f',
        strokeOpacity: 0.8,
        strokeWeight: 1,
        fillColor: '#00f',
        fillOpacity: 0.20
      });

      var infoWindow = new google.maps.InfoWindow({
        content: ContactMapCallout,
        maxWidth: 200,
        height: 200
      });

      google.maps.event.addListener(serviceArea, 'click', function(e) {
        infoWindow.setPosition(e.latLng);
        infoWindow.open(map);
      });

      serviceArea.setMap(map);
    };

    $.getScript('//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=global.gmapInit');
  }

  function resizeDelay() {
    if (window.innerWidth <= 490) {
      resizeTimeoutId = setTimeout(resize, 100);
      size = 'small';
    } else if (window.innerWidth <= 768) {
      resizeTimeoutId = setTimeout(resize, 100);
      size = 'mid';
    } else {
      resizeTimeoutId = setTimeout(resize, 100);
      size = 'large';
    }
  }

  $('[data-toggle]').each(function(){
    var id = $(this).data('toggle');

    $(this).on('click', function() {
      if (size !== 'large') {
        var $target = $(this).siblings('[data-toggle-target="'+ id +'"]');

        if ($target.is(':visible')) {
          $target.slideUp(function(){$(this).removeAttr('style');});
        } else {
          $target.slideDown();
        }
      }
    });
  });

  function resize() {
    switch (size) {
      case 'large':
      $('.main-nav').attr('style',null);
      break;
      case 'small':
      break;
    }
  }

  resizeDelay();
})(jQuery, this);

/**
 *  Work Gallery
 */
(function($){
  var self = {},
    $gallery = $('.work-gallery'),
    $showcase = $('.showcase'),
    item_active = 'active-item',
    COLUMN_COUNT = 3,
    breakPoints = [
      [768, 3],
      [490, 2],
      [0, 1]
    ];

  $gallery.on('click', '.item', function(e){
    e.preventDefault();

    var docWidth = window.innerWidth,
        $targetItem = $(this),
        src = $(this).find('img').attr('src').replace(/\d+[x]\d+/g,'280x200'),
        col = $(this).parent().children().index($(this)) + 1,
        newTop = $targetItem.position().top + $targetItem.height();

    var breakpoint = breakPoints.filter(function(e,i){
      return docWidth > parseInt(e);
    });

    COLUMN_COUNT = parseInt(breakpoint[0][1]);

    if ($(this).hasClass(item_active) && $showcase.is(':visible')) {
      $showcase.fadeOut();
      $(this).removeClass(item_active);

      return;
    } else {
      var $currentlyActive = $gallery.find('.'+item_active).removeClass(item_active);

      $(this).addClass(item_active);
    }

    var oldIndex = $('.item').index($currentlyActive),
        oldRow = Math.floor(oldIndex / COLUMN_COUNT),
        newIndex = $('.item').index($(this)),
        newRow = Math.floor(newIndex / COLUMN_COUNT);

    col = (Math.round((newIndex/COLUMN_COUNT % 1) * COLUMN_COUNT)) + 1;

    // Content compilation
    var $showcaseContent;

    if (self.active === $targetItem.data('name')) {
      $showcase.fadeIn();
      return;
    }

    $showcase
      .find('.showcase-content')
      .html('<div class="loading"></div>')
      .end()
      .css('top', newTop)
      .attr('class', 'showcase col'+col)
      .fadeIn();

    $.ajax({
      url: '/work_project/' + $targetItem.data('name') + '/',
      method: 'get'
    }).complete(function(d,s){
      if (s==='success'){
        $showcaseContent = $(d.responseText).find('[data-ajax-content]');
        self.active = $targetItem.data('name');
        $showcase.find('.showcase-content')
          .html($showcaseContent.hide().fadeIn());
      }
    });

    $showcase.find('.close').on('click', function() {
      console.log('ffs');
      $showcase.fadeOut();
    });

    /**
     *  Attach events for showcase gallery
     */
    $showcase.on('click', '.feature-image-item', function() {
      console.log('clicked');
      var largeUrl = $(this).data('large-url'),
        alt = $(this).attr('alt'),
        $newLargeImage = $('<img>').attr('src', largeUrl).attr('alt', alt),
        $targetImage = $('.feature-image img', $showcase);

      $newLargeImage.on('load', function() {
        $targetImage.fadeOut(function(){
          $(this).replaceWith($newLargeImage);
          $newLargeImage.fadeIn();
        });
      });
    });
  });
})(jQuery);