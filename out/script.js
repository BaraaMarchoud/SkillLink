$(document).ready(function() {
    const eventContainers = $('.rectangle-active');
    let focusedIndex = 0;
  
    function updateFocused() {
      eventContainers.removeClass('focused');
      eventContainers.eq(focusedIndex).addClass('focused');
    }
  
    function scrollLeft() {
      if (focusedIndex > 0) {
        focusedIndex--;
        updateFocused();
        $('.event-container').animate({scrollLeft: focusedIndex * eventContainers.width()});
      }
    }
  
    function scrollRight() {
      if (focusedIndex < eventContainers.length - 1) {
        focusedIndex++;
        updateFocused();
        $('.event-container').animate({scrollLeft: focusedIndex * eventContainers.width()});
      }
    }
  
    $('.scroll-left').on('click', scrollLeft);
    $('.scroll-right').on('click', scrollRight);
  });