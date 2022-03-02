 function ResizeFile(id) {
    const data ={"Original" : '', "Medium" : '',"Small" : ''};
    
    var filesToUploads = document.getElementById(id).files;
    var file = filesToUploads[0];
    
    if (file) {
        var type=file.type;
        var res = type.substring(0, 5);
        
        
        
        var reader = new FileReader();
        
        reader.onload = function(e) {
            
            if (res=="image"){
                var img = document.createElement("img");
                img.src = e.target.result;
                var canvas = document.createElement("canvas");
                var ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0);
                
                var MAX_WIDTH = 30;
                var MAX_HEIGHT = 30;
                var width = img.width;
                var height = img.height;
                
                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }
                canvas.width = width;
                canvas.height = height;
                var ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0, width, height);
                
                data.Small = canvas.toDataURL(file.type);
                
                
                var MAX_WIDTH = 300;
                var MAX_HEIGHT = 300;
                var width = img.width;
                var height = img.height;
                
                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }
                canvas.width = width;
                canvas.height = height;
                var ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0, width, height);
                
                data.Medium = canvas.toDataURL(file.type);
                
                
                
                var MAX_WIDTH = 1000;
                var MAX_HEIGHT = 1000;
                var width = img.width;
                var height = img.height;
                
                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }
                canvas.width = width;
                canvas.height = height;
                var ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0, width, height);
                
                data.Original = canvas.toDataURL(file.type);
                
                if (data.Small==="data:," || data.Small===""){
                   ResizeFile(id);
               } 
               
               var img_show = document.getElementById("img_"+id);
               if (img_show != null) {
                
                img_show.src=data.Original ;
            } 
            
            
            
        }  else {
            data.Original  =  e.target.result;
        }
        
        
        
        document.getElementById("text_"+id).value=JSON.stringify(data);
    };
    reader.readAsDataURL(file);
}
}