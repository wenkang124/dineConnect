$('.multiple-select2').select2({
  tags: true,
});

$('.multiple-select2-without-tags').select2();

$('.single-select2').select2({
  tags: true,
  maximumSelectionLength: 1
});

$('.single-select2-without-tags').select2({
  maximumSelectionLength: 1
});

$('#summernote').summernote({
  tabsize: 2,
  height: 200
});

$('#summernote-disable').summernote('disable');

$(document).on('click', '.delete-btn', function (event) {
    var that = this;
    event.preventDefault();

    bootbox.hideAll();

    var url = $(this).attr("href");
    bootbox.confirm($(that).data('confirm'), function(result){
        if(result){
            $.ajax({
                method: "POST",
                url: url,
                // data: { _token: "{{ csrf_token() }}" },
            })
            .done(function( data ) {
                if(data.success){
                    window.location.href = $(that).data('redirect');
                }else{
                    bootbox.alert(data.message);
                }

            });

        }
    });

});

function initImageUpload(box) {
    let uploadField = box.querySelector(".image-upload");
  
    uploadField.addEventListener("change", getFile);
  
    function getFile(e) {
      let file = e.currentTarget.files[0];
      checkType(file);
    }
  
    function previewImage(file) {
      let thumb = box.querySelector(".js--image-preview"),
        reader = new FileReader();
  
      reader.onload = function () {
        thumb.style.backgroundImage = "url(" + reader.result + ")";
      };
      reader.readAsDataURL(file);
      thumb.className += " js--no-default";
    }
  
    function checkType(file) {
      let imageType = /image.*/;
      if (!file.type.match(imageType)) {
        throw "Datei ist kein Bild";
      } else if (!file) {
        throw "Kein Bild gewählt";
      } else {
        previewImage(file);
      }
    }
}
  
// initialize box-scope
var boxes = document.querySelectorAll(".box");

for (let i = 0; i < boxes.length; i++) {
    let box = boxes[i];
    initDropEffect(box);
    initImageUpload(box);
}
  
/// drop-effect
function initDropEffect(box) {
    let area,
      drop,
      areaWidth,
      areaHeight,
      maxDistance,
      dropWidth,
      dropHeight,
      x,
      y;
  
    // get clickable area for drop effect
    area = box.querySelector(".js--image-preview");
    area.addEventListener("click", fireRipple);
  
    function fireRipple(e) {
        area = e.currentTarget;
        // create drop
        if (!drop) {
            drop = document.createElement("span");
            drop.className = "drop";
            this.appendChild(drop);
        }
        // reset animate class
        drop.className = "drop";
    
        // calculate dimensions of area (longest side)
        areaWidth = getComputedStyle(this, null).getPropertyValue("width");
        areaHeight = getComputedStyle(this, null).getPropertyValue("height");
        maxDistance = Math.max(parseInt(areaWidth, 10), parseInt(areaHeight, 10));
    
        // set drop dimensions to fill area
        drop.style.width = maxDistance + "px";
        drop.style.height = maxDistance + "px";
    
        // calculate dimensions of drop
        dropWidth = getComputedStyle(this, null).getPropertyValue("width");
        dropHeight = getComputedStyle(this, null).getPropertyValue("height");
    
        // calculate relative coordinates of click
        // logic: click coordinates relative to page - parent's position relative to page - half of self height/width to make it controllable from the center
        x = e.pageX - this.offsetLeft - parseInt(dropWidth, 10) / 2;
        y = e.pageY - this.offsetTop - parseInt(dropHeight, 10) / 2 - 30;
    
        // position drop and animate
        drop.style.top = y + "px";
        drop.style.left = x + "px";
        drop.className += " animate";
        e.stopPropagation();
    }
}

$(".addmore").click(function() {
    let clone_html = $('.'+$(this).data('clone')).clone().html().replace(/_temp/g, '');
    let container = $('.'+$(this).data('container'));
    let count = $(this).data('input-count');

    $(container).append(clone_html);

    for($i = 1; $i <= count; $i++) {
      $('.'+$(this).data('input')+'-'+$i).attr('name', $('.'+$(this).data('input-name')+'-'+$i))
      $('.'+$(this).data('input')+'-'+$i).attr('required', true);
    }
    // $('.flavour_title_input').attr('name', 'flavour_titles[]');
    // $('.flavour_title_input').attr('required', true);
    // $('.flavour_percentage_input').attr('name', 'flavour_percentages[]');
    // $('.flavour_percentage_input').attr('required', true);
});

$(document).on('click','.inputRemove',function() {
  $(this).parent().parent().parent().remove();
});