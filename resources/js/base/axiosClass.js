import generalTools from "./generalTools";


var ACXIOSCLASSFUNCT = function () {

    // ============================================================================
    this.updateElements = function (url) {
      
        // alert(url);
      if (!url || url == undefined) return;

        axios
          .get(url)
          .then(function (response) {
            generalTools.updateElements(response.data);
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
          .finally(function () {
            // always executed
          });
    };

    // ============================================================================
}
 
var axiosClass = new ACXIOSCLASSFUNCT();

export default axiosClass;
