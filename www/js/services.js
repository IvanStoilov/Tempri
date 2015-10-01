angular.module('starter.services', [])

.factory('Instance', function($firebaseObject) {
  // Might use a resource here that returns a JSON array

  return {
    getData: getData
  };

  function getData() {
    var itemsRef = new Firebase("https://flickering-fire-163.firebaseio.com/instances/IRINA");
    return $firebaseObject(itemsRef);
  }
});
