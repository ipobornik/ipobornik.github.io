adsApp.controller("AdDetailsController",
    function AdDetailsController($scope, adsData) {

        $scope.ad = adsData.getAd("1.json");
    });
