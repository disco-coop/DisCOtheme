console.log("DisCOtheme/app.js")
$(function () {
    console.log("done")
    $('.image-link').each(function(i,e){
        console.log(e)
        $(e).wrap('<div>')
    })
})
