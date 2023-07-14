import './style.scss';

console.log("DisCOtheme/app.js")
jQuery(function () {
  jQuery('.image-link').each(function (i, e) {
    // console.log(e)
    jQuery(e).wrap('<div>')
  })

  jQuery('.add-blob').each((i, e) => {
    // console.log("add-blob", e);
    let n = 1 + Math.floor(Math.random() * 3);
    let img = 'blob0' + n + '.svg';
    let tag = jQuery('<img class="blob" src="/wp-content/themes/DisCOtheme/img/' + img + '">')
    jQuery(e).prepend(tag);
  })
})
