
const image = {
    render: function(targetView, fileImage){
        var reader = new FileReader();
        reader.onload = function (e1) {
            $(targetView).attr("src", e1.target.result);
        }
        reader.readAsDataURL(fileImage);
    }
}

function changeSearchParam(params){
    var s = new URLSearchParams(window.location.search);
    var hash = location.hash;
    console.log(hash)
    for(var k in params){
        (s.get(k) == null) ? s.append(k, params[k]) : s.set(k, params[k]);
    }
    return location.pathname+"?"+s.toString()+hash;
}

function isNullInput(name){
  var ip = $(`[name="${name}"]`).val().trim()
  if(ip.length == 0){
    $(`[for="${name}"]`).removeClass("d-none")
    return true
  }else{
    $(`[for="${name}"]`).addClass("d-none")
  }
  return false
}
