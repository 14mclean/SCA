<?php
    function location_distance(array $location1, array $location2): float {
        define("R", 6371e3); // earth radius (m)
        $latitude1_radians = $location1[0] * M_PI / 180;
        $latitude2_radians = $location2[0] * M_PI / 180;
        $latitude_delta = ($location2[0] - $location1[0]) * M_PI / 180;
        $longitude_delta = ($location2[1] - $location1[1]) * M_PI / 180;
        $haversine_a = 
            sin($latitude_delta / 2) *
            sin($latitude_delta / 2) +
            cos($latitude1_radians) *
            cos($latitude2_radians) *
            sin($longitude_delta / 2) *
            sin($longitude_delta / 2);
        $haversine_c = 2 * atan2(
            sqrt($haversine_a),
            sqrt(1 - $haversine_a)
        );
        $distance = R * $haversine_c;
        return $distance;
    }
?>

<script>
    function location_distance(loction1, location2) {
        const R = 6371e3, // earth radius (m)
            latitude1_radians = location1[0] * Math.PI / 180,
            latitude2_radians = location2[0] * Math.PI / 180,
            latitude_delta = (location2[0] - location1[0]) * Math.PI / 180,
            longitude_delta = (location2[1] - location1[1]) * Math.PI / 180;
        const haversine_a =
            Math.sin(latitude_delta / 2) *
            Math.sin(latitude_delta / 2) +
            Math.cos(latitude1_radians) *
            Math.cos(latitude2_radians) *
            Math.sin(longitude_delta / 2) *
            Math.sin(longitude_delta / 2);
        const haversine_c = 2 * Math.atan2(
                Math.sqrt(haversine_a),
                Math.sqrt(1 - haversine_a)
            );
        const distance = R * haversine_c;
    }
</script>