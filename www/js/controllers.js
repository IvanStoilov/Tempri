angular.module('starter.controllers', [])

.controller('DefaultCtrl', function($scope, Instance) {
  activate();

  function activate() {
    Instance.getData().$bindTo($scope, "data");
  }
})
.controller('SettingsCtrl', function($scope, Instance) {
  activate();

  function activate() {
    Instance.getData().$bindTo($scope, "data");
  }
})
.controller('ProgramsCtrl', function($scope, Instance) {

  $scope.daysOfWeekLetters = ['M', 'T', 'W', 'T', 'F', 'S', 'S'];

  activate();

  function activate() {
    Instance.getData().$bindTo($scope, "data");
  }

  $scope.getTime = function (num) {
    var minutes = (num % 60);
    if (minutes < 10) {
      minutes = "0" + minutes;
    }

    return Math.floor(num / 60) + ":" + minutes;
  }

  $scope.addProgram = function () {
    $scope.data.programs.push({
      from: 200,
      to: 300,
      days: [1,1,1,1,1,1,1]
    });
  }
});
