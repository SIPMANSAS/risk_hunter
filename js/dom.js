const id = str=>document.getElementById(str);
const query = (reglascss,one=false) => one ? 
                                      document.querySelector(reglascss):
                                      document.querySelectorAll(reglascss):
                                      
const create = str=>document.createElement(str);