// npm package: flatpickr
// github link: https://github.com/flatpickr/flatpickr

$(function() {
  'use strict';

  // date picker 
  if($('#flatpickr-date').length) {
    flatpickr("#flatpickr-date", {
      wrap: true,
      dateFormat: "Y-m-d H:i",
      // minDate:"today"
    });
  }
  
  // date picker 
  if($('#registration-date').length) {
    flatpickr("#registration-date", {
      wrap: true,
      dateFormat: "Y-m-d H:i",
    });
  }

  if($('#flatpickr_default').length) {
    flatpickr("#flatpickr_default", {
      wrap: true,
      dateFormat: "Y-m-d H:i",
    });
  }
  if($('#challan_date').length) {
    flatpickr("#challan_date", {
      wrap: true,
      dateFormat: "Y-m-d H:i",
    });
  }
  // if($('#flatpickr-bill-end').length) {
  //   flatpickr("#flatpickr-bill-end", {
  //     wrap: true,
  //     dateFormat: "Y-m-d H:i",
  //     minDate:"today"
  //   });
  // }


  // time picker
  if($('.flatpickr').length) {
    
    console.log("time-picker");

    flatpickr(".flatpickr", {
      wrap: true,
      enableTime: true,
      noCalendar: false,
      dateFormat: "Y-m-d H:i",
      minuteIncrement:30,
      // minDate: "today",
    });
  }

  // if($('#flatpickr-time-to').length) {
  //   flatpickr("#flatpickr-time-to", {
  //     wrap: true,
  //     enableTime: true,
  //     noCalendar: false,
  //     dateFormat: "Y-m-d H:i",
  //     minuteIncrement:30,
  //   });
  // }

  

});