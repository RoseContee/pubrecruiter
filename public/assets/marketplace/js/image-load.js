function blobToBase64(blob) {
    if (typeof blob !== "object" || !blob) return blob
    return new Promise((resolve, _) => {
        const reader = new FileReader()
        reader.onloadend = () => resolve(reader.result)
        reader.readAsDataURL(blob)
    });
}

function getImageObject(img) {
    return new Promise (function (resolved, rejected) {
        const i = new Image()
        i.onload = function(){
            resolved(i)
        }
        i.src = img
    })
}
