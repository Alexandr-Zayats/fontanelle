'use strict';
;( function ( document, window, index )
{
    // verify drag & drop support in browser
    var dragDropSupported = function()
    {
        var div = document.createElement( 'div' );
        return ( ( 'draggable' in div ) || ( 'ondragstart' in div && 'ondrop' in div ) ) && 'FormData' in window && 'FileReader' in window;
    }();
    // IE fix for .remove() function
    if (!('remove' in Element.prototype)) {
        Element.prototype.remove = function() {
            if (this.parentNode) {
                this.parentNode.removeChild(this);
            }
        };
    }
    var form = document.querySelector( '.upload_form' );
    var input = form.querySelector( 'input[type="file"]' ),
    label = form.querySelector( 'label' ),
    droppedFiles = false,
    formSubmit = function()
    {
        var event = document.createEvent( 'HTMLEvents' );
        event.initEvent( 'submit', true, true );
        form.dispatchEvent( event );
    };
    // automatically submit the form on file select
    input.addEventListener( 'change', function( e )
    {
        formSubmit();
    });
    // drag&drop event action
    if( dragDropSupported )
    {
        [ 'drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop' ].forEach( function( event )
        {
            form.addEventListener( event, function( e )
            {
                e.preventDefault();
                e.stopPropagation();
            });
        });
        [ 'dragover', 'dragenter' ].forEach( function( event )
        {
            form.addEventListener( event, function()
            {
                form.classList.add( 'drag_start' );
            });
        });
        [ 'dragleave', 'dragend', 'drop' ].forEach( function( event )
        {
            form.addEventListener( event, function()
            {
                form.classList.remove( 'drag_start' );
            });
        });
        form.addEventListener( 'drop', function( e )
        {
            droppedFiles = e.dataTransfer.files;
            formSubmit();
        });
    }else{
        alert("Drag & Drop not Supported in this browser.");
    }
    // if the form was submitted
    form.addEventListener( 'submit', function( e )
    {
        e.preventDefault();
        if(form.classList.contains("uploading")) return false;
        form.classList.add("uploading");
        let div=document.createElement("div");
        div.setAttribute("class","image_box loading");
        document.querySelector(".upload_result").appendChild(div);
        let up_status=document.querySelector(".upload_status");
        up_status.setAttribute("class","upload_status");
        document.querySelector(".upload_box>label").innerHTML="Select Files";
        up_status.innerHTML="File upload started...";
        up_status.classList.add("success");
        // gathering the form data
        var ajaxData = new FormData( form );
        if( droppedFiles )
        {
            Array.prototype.forEach.call( droppedFiles, function( file )
            {
                ajaxData.append( input.getAttribute( 'name' ), file );
            });
        }
        //creating JS based ajax request
        var ajax = new XMLHttpRequest();
        ajax.open( form.getAttribute( 'method' ), form.getAttribute( 'action' ), true );
        ajax.onload = function()
        {
            form.classList.remove( 'uploading' );
            up_status.setAttribute("class","upload_status");
            if( ajax.status >= 200 && ajax.status < 400 ){
                let data=JSON.parse( ajax.responseText );
                if(data["status" ]=="success" ){
                    up_status.classList.add("success" );
                    let loader = document.querySelectorAll(".loading, .error" );
                    Array.prototype.forEach.call( loader, function( x ){
                        x.remove();
                    });
                    var files=data["files" ];
                    for(let i=0; i<files.length; i++){
                        let div=document.createElement("div" );
                        div.setAttribute("class" ,"image_box" );
                        let img=document.createElement("img" );
                        img.setAttribute("src" ,files[i]);
                        div.appendChild(img);
                        document.querySelector(".upload_result" ).appendChild(div);
                        up_status.innerHTML="Files uploaded Successfully";
                        up_status.classList.add("success" );
                    }
                }else{
                    up_status.innerHTML = data["message" ];
                    up_status.classList.add("error" );
                    let stat_loading = document.querySelectorAll(".loading" );
                    Array.prototype.forEach.call( stat_loading, function( l ){
                        l.classList.add("error" );
                        l.classList.remove("loading" );
                    });
                }
            }else{
                form.classList.remove( 'uploading' );
                alert( 'Oops! Something went wrong' );
            }
            droppedFiles=false;
        };
        ajax.onerror = function(){
            form.classList.remove( 'uploading' );
            alert( 'Some error occurred. Try again' );
        };
        ajax.send( ajaxData );
    });
}( document, window, 0 ));
