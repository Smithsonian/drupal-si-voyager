// Custom scripts file

//window.onload = set3D;
let wrapper = null;
let newScene = null;
let id = '';

window.onload = set3D;

function set3D() {
  // Get all elements with a data-3d attribute
  let elements = document.querySelectorAll('[data-3d]');

  // Iterate over the NodeList
  elements.forEach(function(element) {
    let data3dValue = element.getAttribute('data-3d');
    console.log(data3dValue);

    wrapper = document.getElementById('voyager__wrapper-' + data3dValue);
    newScene = document.createElement('voyager-explorer');

    let url = 'https://3d-api.si.edu/content/document/' + data3dValue + '/document.json';

    newScene.setAttribute('root', url);
    newScene.setAttribute('document', 'document.json');
    newScene.setAttribute('id', data3dValue);
    newScene.setAttribute('class', 'voyager');
    wrapper.appendChild(newScene);
  });

}
