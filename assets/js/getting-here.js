/**
 * Getting Here Section JavaScript with Custom Markers (WORKING VERSION)
 * File: assets/js/getting-here.js
 */

// Define callback function immediately in global scope
window.initNirupMap = function() {
;
    
    if (!window.nirupMapData) {
        console.error('❌ Map data not available');
        return;
    }
    if (!window.nirupMapData) {
        console.error('❌ Map data not available');
        return;
    }

    const mapElement = document.getElementById('nirup-ferry-map');
    if (!mapElement) {
        console.error('❌ Map container not found');
        return;
    }

    // Hide loading indicator
    const loadingElement = mapElement.querySelector('.map-loading');
    if (loadingElement) {
        loadingElement.style.display = 'none';
    }

    // Simple map options
    const mapOptions = {
        zoom: parseInt(window.nirupMapData.zoom) || 10,
        center: window.nirupMapData.center,
        mapTypeId: google.maps.MapTypeId.TERRAIN,
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: true,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: true
    };

    try {
        // Create map
        const map = new google.maps.Map(mapElement, mapOptions);

        // Create Nirup Island marker (large custom marker)
        const nirupMarker = new google.maps.Marker({
            position: window.nirupMapData.center,
            map: map,
            title: 'Nirup Island',
            icon: {
                url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                    <svg width="101" height="134" viewBox="0 0 101 134" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M50.7461 0.311523C23.1471 0.34789 0.782552 22.6565 0.746094 50.1863C0.746094 85.9922 47.3294 130.838 49.3086 132.729C50.1081 133.506 51.3841 133.506 52.1836 132.729C54.1628 130.838 100.746 85.9922 100.746 50.1863C100.71 22.6565 78.345 0.34789 50.7461 0.311523Z" fill="#22284F"/>
                    <g clip-path="url(#clip0_845_201)">
                    <path d="M33.9919 63.6142C33.9919 62.4446 33.9919 62.2279 33.9777 61.9822C33.9614 61.7199 33.8872 61.5892 33.7206 61.5508C33.6373 61.527 33.5387 61.5197 33.4493 61.5197C33.3731 61.5197 33.3284 61.5032 33.3284 61.442C33.3284 61.3964 33.3893 61.3818 33.5082 61.3818C33.7958 61.3818 34.2714 61.4036 34.4908 61.4036C34.6798 61.4036 35.1249 61.3818 35.4125 61.3818C35.51 61.3818 35.57 61.3964 35.57 61.442C35.57 61.5042 35.5253 61.5197 35.4501 61.5197C35.3749 61.5197 35.3129 61.527 35.2235 61.5415C35.0182 61.5809 34.9583 61.7126 34.944 61.9811C34.9278 62.2269 34.9278 62.4436 34.9278 63.6132V64.9704C34.9278 65.717 34.9278 66.3256 34.9583 66.6564C34.9816 66.8638 35.0345 67.0038 35.2611 67.0349C35.3668 67.0494 35.5324 67.0639 35.6462 67.0639C35.7285 67.0639 35.7671 67.0877 35.7671 67.1261C35.7671 67.1811 35.7061 67.2039 35.6228 67.2039C35.1249 67.2039 34.6494 67.18 34.4461 67.18C34.2714 67.18 33.7958 67.2039 33.494 67.2039C33.3954 67.2039 33.3426 67.18 33.3426 67.1261C33.3426 67.0877 33.3731 67.0639 33.4635 67.0639C33.5773 67.0639 33.6667 67.0494 33.7348 67.0349C33.8862 67.0038 33.932 66.8731 33.9543 66.6491C33.9919 66.3256 33.9919 65.716 33.9919 64.9704V63.6132V63.6142Z" fill="white"/>
                    <path d="M37.7485 67.1111C37.6276 67.0572 37.6042 67.0189 37.6042 66.8488C37.6042 66.4247 37.6347 65.9633 37.6418 65.8389C37.65 65.7238 37.6723 65.6388 37.7323 65.6388C37.8004 65.6388 37.8075 65.7083 37.8075 65.7694C37.8075 65.87 37.838 66.0318 37.8766 66.1624C38.0422 66.7316 38.4883 66.9411 38.9557 66.9411C39.6345 66.9411 39.9668 66.4704 39.9668 66.0629C39.9668 65.6865 39.854 65.3319 39.227 64.8311L38.8805 64.5532C38.0503 63.8906 37.7628 63.3525 37.7628 62.7283C37.7628 61.8801 38.4578 61.2715 39.5065 61.2715C39.9973 61.2715 40.3143 61.3492 40.5104 61.4021C40.5785 61.4187 40.6171 61.4405 40.6171 61.4944C40.6171 61.594 40.5866 61.8179 40.5866 62.4183C40.5866 62.5873 40.5633 62.6495 40.5033 62.6495C40.4505 62.6495 40.4281 62.6039 40.4281 62.5116C40.4281 62.4421 40.3905 62.2036 40.232 62.0035C40.1182 61.8563 39.8987 61.6251 39.4089 61.6251C38.8511 61.6251 38.5106 61.9558 38.5106 62.4183C38.5106 62.7729 38.6854 63.0425 39.3114 63.5277L39.5237 63.6895C40.4362 64.3904 40.7614 64.9213 40.7614 65.6543C40.7614 66.1002 40.5958 66.6311 40.0521 66.994C39.6741 67.2408 39.2514 67.3102 38.8521 67.3102C38.4141 67.3102 38.0747 67.2563 37.7506 67.1101" fill="white"/>
                    <path d="M44.2612 64.9705C44.2612 65.9566 44.2612 66.4875 44.4197 66.6264C44.5477 66.7425 44.7438 66.7954 45.3322 66.7954C45.7315 66.7954 46.0272 66.7881 46.2152 66.5808C46.3057 66.4802 46.3971 66.2645 46.4124 66.1183C46.4195 66.0489 46.4337 66.0022 46.4947 66.0022C46.5485 66.0022 46.5556 66.0406 46.5556 66.1328C46.5556 66.2179 46.5018 66.7954 46.4418 67.0183C46.3971 67.1873 46.3595 67.2257 45.9673 67.2257C45.4236 67.2257 45.0314 67.2112 44.691 67.2039C44.3526 67.1873 44.0793 67.1801 43.7714 67.1801C43.6881 67.1801 43.5214 67.1801 43.3405 67.1873C43.1678 67.1873 42.9717 67.2039 42.8203 67.2039C42.7227 67.2039 42.6689 67.1801 42.6689 67.1262C42.6689 67.0878 42.6994 67.064 42.7898 67.064C42.9036 67.064 42.993 67.0494 43.0611 67.0349C43.2125 67.0038 43.2501 66.8338 43.2806 66.6108C43.3182 66.2873 43.3182 65.6777 43.3182 64.9705V63.6132C43.3182 62.4437 43.3182 62.2269 43.304 61.9812C43.2877 61.7189 43.2288 61.5955 42.9798 61.5416C42.9188 61.5271 42.8284 61.5198 42.7298 61.5198C42.6475 61.5198 42.6018 61.5032 42.6018 61.4503C42.6018 61.3974 42.6546 61.3809 42.7674 61.3809C43.1221 61.3809 43.5976 61.4026 43.8019 61.4026C43.9838 61.4026 44.5345 61.3809 44.8292 61.3809C44.9359 61.3809 44.9877 61.3954 44.9877 61.4503C44.9877 61.5053 44.943 61.5198 44.8526 61.5198C44.7692 61.5198 44.6493 61.5271 44.5579 61.5416C44.3547 61.581 44.2937 61.7127 44.2784 61.9812C44.2642 62.2269 44.2642 62.4437 44.2642 63.6132V64.9705H44.2612Z" fill="white"/>
                    <path d="M49.0969 65.1945C49.0593 65.1945 49.043 65.2091 49.0288 65.2547L48.6203 66.3569C48.5451 66.5497 48.5075 66.7333 48.5075 66.8266C48.5075 66.9645 48.5756 67.0651 48.8093 67.0651H48.9221C49.0125 67.0651 49.0359 67.0816 49.0359 67.1273C49.0359 67.1895 48.9912 67.205 48.9079 67.205C48.666 67.205 48.3409 67.1812 48.1071 67.1812C48.0248 67.1812 47.6092 67.205 47.216 67.205C47.1184 67.205 47.0737 67.1884 47.0737 67.1273C47.0737 67.0816 47.1042 67.0651 47.1642 67.0651C47.2322 67.0651 47.3369 67.0578 47.3979 67.0505C47.7454 67.0049 47.8887 66.7426 48.0401 66.3579L49.9352 61.5209C50.0256 61.2969 50.0703 61.2119 50.1455 61.2119C50.2146 61.2119 50.2593 61.2814 50.3345 61.4587C50.5164 61.8828 51.7236 65.0245 52.2063 66.1962C52.4928 66.8888 52.7123 66.9966 52.8708 67.036C52.9846 67.0578 53.0974 67.0651 53.1879 67.0651C53.2488 67.0651 53.2854 67.0733 53.2854 67.1273C53.2854 67.1895 53.2173 67.205 52.9379 67.205C52.6585 67.205 52.1158 67.205 51.5112 67.1884C51.3761 67.1812 51.2846 67.1812 51.2846 67.1262C51.2846 67.0806 51.3151 67.064 51.3903 67.0568C51.4432 67.0422 51.496 66.9728 51.4584 66.8805L50.8538 65.2474C50.8396 65.2091 50.8162 65.1945 50.7786 65.1945H49.0959H49.0969ZM50.6373 64.8088C50.6749 64.8088 50.6821 64.785 50.6749 64.7622L49.9962 62.8605C49.988 62.8294 49.9799 62.79 49.9586 62.79C49.9352 62.79 49.92 62.8294 49.9128 62.8605L49.2188 64.7549C49.2107 64.786 49.2188 64.8088 49.2493 64.8088H50.6384H50.6373Z" fill="white"/>
                    <path d="M55.2638 66.1564C55.278 66.7568 55.3766 66.9569 55.528 67.0118C55.656 67.0575 55.7993 67.0647 55.9202 67.0647C56.0035 67.0647 56.0483 67.0813 56.0483 67.1269C56.0483 67.1891 55.9802 67.2047 55.8755 67.2047C55.3837 67.2047 55.0819 67.1808 54.9376 67.1808C54.8695 67.1808 54.5149 67.2047 54.1227 67.2047C54.0251 67.2047 53.957 67.1964 53.957 67.1269C53.957 67.0813 54.0017 67.0647 54.078 67.0647C54.1755 67.0647 54.3117 67.0575 54.4163 67.0263C54.6124 66.9641 54.6429 66.7422 54.6511 66.0714L54.7191 61.5112C54.7191 61.3578 54.7405 61.251 54.8177 61.251C54.9 61.251 54.9681 61.3505 55.0961 61.4895C55.1866 61.589 56.3348 62.8446 57.4363 63.9614C57.9495 64.485 58.9697 65.5944 59.0977 65.7168H59.1353L59.0591 62.2588C59.052 61.7891 58.9839 61.6419 58.802 61.5662C58.6892 61.5206 58.5073 61.5206 58.4027 61.5206C58.3122 61.5206 58.2817 61.4967 58.2817 61.4511C58.2817 61.3889 58.3651 61.3816 58.4779 61.3816C58.8721 61.3816 59.2339 61.4034 59.3924 61.4034C59.4747 61.4034 59.7613 61.3816 60.1321 61.3816C60.2307 61.3816 60.3049 61.3889 60.3049 61.4511C60.3049 61.4967 60.2602 61.5206 60.1687 61.5206C60.0935 61.5206 60.0336 61.5206 59.9421 61.5423C59.7298 61.6045 59.6698 61.7663 59.6627 62.1976L59.5804 67.0585C59.5804 67.2275 59.5499 67.298 59.4818 67.298C59.3985 67.298 59.307 67.213 59.2247 67.1269C58.7492 66.6645 57.7828 65.6566 56.9963 64.8624C56.1743 64.0308 55.3359 63.0686 55.2008 62.9214H55.1774L55.2607 66.1574L55.2638 66.1564Z" fill="white"/>
                    <path d="M62.7518 63.6142C62.7518 62.4446 62.7518 62.2279 62.7376 61.9822C62.7213 61.7199 62.6624 61.5965 62.4134 61.5426C62.3525 61.528 62.2244 61.5208 62.1188 61.5208C62.0354 61.5208 61.9907 61.5042 61.9907 61.4513C61.9907 61.3984 62.0425 61.3818 62.1564 61.3818C62.5557 61.3818 63.0313 61.4036 63.2436 61.4036C63.4773 61.4036 63.9529 61.3818 64.4061 61.3818C65.3491 61.3818 66.6101 61.3818 67.4332 62.259C67.8092 62.6593 68.1648 63.299 68.1648 64.2166C68.1648 65.1861 67.7655 65.9264 67.3428 66.365C66.9952 66.7269 66.2108 67.2744 64.8136 67.2744C64.5423 67.2744 64.2323 67.2505 63.9458 67.2277C63.6602 67.2059 63.395 67.1821 63.207 67.1821C63.1237 67.1821 62.9571 67.1821 62.7762 67.1894C62.6035 67.1894 62.4073 67.2059 62.2559 67.2059C62.1574 67.2059 62.1045 67.1821 62.1045 67.1282C62.1045 67.0898 62.135 67.066 62.2255 67.066C62.3393 67.066 62.4287 67.0514 62.4968 67.0369C62.6482 67.0058 62.6858 66.8358 62.7162 66.6129C62.7538 66.2893 62.7538 65.6797 62.7538 64.9725V63.6153L62.7518 63.6142ZM63.6958 64.4613C63.6958 65.2784 63.7029 65.8715 63.71 66.0187C63.7172 66.2105 63.7334 66.5185 63.7934 66.6025C63.8909 66.7497 64.1856 66.9115 64.7811 66.9115C65.5513 66.9115 66.0644 66.757 66.5176 66.3567C67.0013 65.9327 67.1517 65.2328 67.1517 64.4396C67.1517 63.4608 66.7524 62.8293 66.4282 62.5131C65.7332 61.8349 64.8725 61.7437 64.2842 61.7437C64.1328 61.7437 63.8543 61.7655 63.7934 61.7966C63.7253 61.8277 63.7029 61.8661 63.7029 61.9511C63.6958 62.2134 63.6958 62.8822 63.6958 63.4919V64.4613Z" fill="white"/>
                    <path d="M37.1298 47.8879C37.1298 45.1402 37.1298 44.6342 37.0953 44.0556C37.0597 43.4418 36.8819 43.1349 36.4927 43.0436C36.2976 42.9907 36.0669 42.971 35.8556 42.971C35.6777 42.971 35.571 42.9358 35.571 42.7906C35.571 42.6828 35.7133 42.6465 35.9968 42.6465C36.6705 42.6465 37.7862 42.7004 38.3004 42.7004C38.7435 42.7004 39.787 42.6465 40.4607 42.6465C40.6914 42.6465 40.8326 42.6828 40.8326 42.7906C40.8326 42.9358 40.7259 42.971 40.5481 42.971C40.3703 42.971 40.2291 42.9897 40.0177 43.0249C39.5391 43.1162 39.3978 43.4221 39.3633 44.0546C39.3267 44.6331 39.3267 45.1391 39.3267 47.8868V51.0669C39.3267 52.8213 39.3267 54.248 39.3978 55.0257C39.4507 55.513 39.5757 55.8396 40.1061 55.9112C40.354 55.9464 40.7453 55.9827 41.0105 55.9827C41.2056 55.9827 41.293 56.0377 41.293 56.1268C41.293 56.2533 41.1517 56.3083 40.9566 56.3083C39.787 56.3083 38.6723 56.2533 38.1937 56.2533C37.7873 56.2533 36.6705 56.3083 35.9623 56.3083C35.7316 56.3083 35.6076 56.2533 35.6076 56.1268C35.6076 56.0366 35.6788 55.9827 35.8901 55.9827C36.1574 55.9827 36.3687 55.9464 36.5293 55.9112C36.8829 55.8386 36.9896 55.5317 37.0424 55.0081C37.1308 54.2491 37.1308 52.8213 37.1308 51.0669V47.8868L37.1298 47.8879Z" fill="white"/>
                    <path d="M46.9122 47.8879C46.9122 45.1402 46.9122 44.6342 46.8776 44.0556C46.8421 43.4418 46.7008 43.1525 46.1145 43.026C45.9733 42.9907 45.6715 42.971 45.4256 42.971C45.2295 42.971 45.1238 42.9358 45.1238 42.8093C45.1238 42.6828 45.2477 42.6465 45.513 42.6465C46.4519 42.6465 47.5676 42.7004 47.9385 42.7004C48.5411 42.7004 49.8865 42.6465 50.4362 42.6465C51.5519 42.6465 52.7388 42.7554 53.695 43.4231C54.1908 43.7673 54.8991 44.6881 54.8991 45.9002C54.8991 47.2377 54.3494 48.4664 52.5609 49.9481C54.137 51.9721 55.3584 53.5803 56.404 54.7011C57.3968 55.7484 58.1213 55.8759 58.3875 55.9298C58.5826 55.9651 58.7422 55.9838 58.8834 55.9838C59.0246 55.9838 59.0968 56.0387 59.0968 56.1279C59.0968 56.272 58.9728 56.3093 58.7594 56.3093H57.0777C56.0849 56.3093 55.6429 56.2181 55.1816 55.9651C54.4205 55.5503 53.7478 54.7011 52.756 53.3086C52.0478 52.3153 51.2328 51.0866 51.0022 50.8139C50.9148 50.7061 50.8071 50.6874 50.6831 50.6874L49.1426 50.6522C49.0532 50.6522 49.0004 50.6874 49.0004 50.7963V51.0493C49.0004 52.7301 49.0004 54.1578 49.0898 54.9168C49.1426 55.4404 49.2483 55.8396 49.7808 55.9122C50.046 55.9475 50.4352 55.9838 50.6475 55.9838C50.7898 55.9838 50.8609 56.0387 50.8609 56.1279C50.8609 56.2544 50.737 56.3093 50.5063 56.3093C49.48 56.3093 48.1681 56.2544 47.9029 56.2544C47.5666 56.2544 46.4509 56.3093 45.7426 56.3093C45.5119 56.3093 45.388 56.2544 45.388 56.1279C45.388 56.0377 45.4591 55.9838 45.6705 55.9838C45.9377 55.9838 46.1491 55.9475 46.3096 55.9122C46.6632 55.8396 46.7527 55.4415 46.8228 54.9168C46.9112 54.1578 46.9112 52.7301 46.9112 51.0669V47.8868L46.9122 47.8879ZM49.0014 49.3156C49.0014 49.5147 49.038 49.5863 49.1619 49.6412C49.5338 49.7677 50.0643 49.8216 50.5073 49.8216C51.2156 49.8216 51.4462 49.7501 51.7653 49.5137C52.2978 49.1166 52.8109 48.285 52.8109 46.8033C52.8109 44.237 51.1455 43.4957 50.1009 43.4957C49.6578 43.4957 49.3398 43.5143 49.1619 43.5693C49.038 43.6046 49.0014 43.6771 49.0014 43.8223V49.3156Z" fill="white"/>
                    <path d="M61.2144 47.8878C61.2144 45.1401 61.2144 44.6341 61.1788 44.0555C61.1443 43.4417 61.003 43.1524 60.4177 43.0259C60.2765 42.9907 59.9747 42.972 59.7268 42.972C59.5317 42.972 59.427 42.9367 59.427 42.8102C59.427 42.6838 59.551 42.6475 59.8162 42.6475C60.7551 42.6475 61.8698 42.7014 62.4023 42.7014C62.828 42.7014 63.9428 42.6475 64.5799 42.6475C64.8471 42.6475 64.9711 42.6838 64.9711 42.8102C64.9711 42.9367 64.8644 42.972 64.6866 42.972C64.4915 42.972 64.3848 42.9907 64.1734 43.0259C63.6948 43.1172 63.5536 43.423 63.519 44.0555C63.4824 44.6341 63.4824 45.1401 63.4824 47.8878V50.4178C63.4824 53.039 63.9956 54.1412 64.8644 54.8639C65.6621 55.5337 66.477 55.6052 67.0786 55.6052C67.859 55.6052 68.8152 55.3522 69.5234 54.6295C70.4969 53.6341 70.5497 52.0083 70.5497 50.1472V47.8878C70.5497 45.1401 70.5497 44.6341 70.5152 44.0555C70.4796 43.4417 70.3374 43.1524 69.7541 43.0259C69.6108 42.9907 69.311 42.972 69.1149 42.972C68.9188 42.972 68.8152 42.9367 68.8152 42.8102C68.8152 42.6838 68.9391 42.6475 69.1871 42.6475C70.0894 42.6475 71.2062 42.7014 71.2234 42.7014C71.4358 42.7014 72.5515 42.6475 73.2425 42.6475C73.4905 42.6475 73.6144 42.6838 73.6144 42.8102C73.6144 42.9367 73.5077 42.972 73.2954 42.972C73.1003 42.972 72.9936 42.9907 72.7822 43.0259C72.3036 43.1172 72.1624 43.423 72.1258 44.0555C72.0912 44.6341 72.0912 45.1401 72.0912 47.8878V49.8216C72.0912 51.8279 71.8961 53.9597 70.4085 55.262C69.1505 56.3642 67.8763 56.5633 66.725 56.5633C65.786 56.5633 64.086 56.5094 62.7925 55.3149C61.8891 54.4833 61.2164 53.1479 61.2164 50.5266V47.8878H61.2144Z" fill="white"/>
                    <path d="M78.8455 47.8878C78.8455 45.1401 78.8455 44.6341 78.811 44.0555C78.7754 43.4417 78.6342 43.1524 78.0479 43.0259C77.9066 42.9907 77.6048 42.972 77.3569 42.972C77.1618 42.972 77.0571 42.9367 77.0571 42.8102C77.0571 42.6838 77.1811 42.6475 77.4463 42.6475C78.3852 42.6475 79.502 42.7014 79.9958 42.7014C80.7224 42.7014 81.7497 42.6475 82.5646 42.6475C84.7788 42.6475 85.5755 43.4065 85.86 43.6771C86.2492 44.0566 86.7451 44.8705 86.7451 45.8286C86.7451 48.3948 84.9018 50.2021 82.3868 50.2021C82.2984 50.2021 82.1043 50.2021 82.0149 50.1834C81.9275 50.1658 81.8025 50.1482 81.8025 50.0217C81.8025 49.8776 81.9265 49.8226 82.2984 49.8226C83.2902 49.8226 84.6721 48.6841 84.6721 46.8395C84.6721 46.2433 84.6193 45.0323 83.6265 44.1291C82.9894 43.5329 82.2618 43.4241 81.8554 43.4241C81.5902 43.4241 81.3249 43.4427 81.1644 43.4967C81.076 43.5329 81.0231 43.6418 81.0231 43.8409V51.0689C81.0231 52.7321 81.0231 54.1588 81.1115 54.9365C81.1654 55.4425 81.2721 55.8416 81.8025 55.9132C82.0505 55.9484 82.4397 55.9847 82.7059 55.9847C82.902 55.9847 82.9904 56.0397 82.9904 56.1289C82.9904 56.2554 82.8492 56.3103 82.6541 56.3103C81.4845 56.3103 80.3677 56.2554 79.9084 56.2554C79.502 56.2554 78.3852 56.3103 77.677 56.3103C77.4463 56.3103 77.3223 56.2554 77.3223 56.1289C77.3223 56.0387 77.3935 55.9847 77.6048 55.9847C77.8721 55.9847 78.0834 55.9484 78.244 55.9132C78.5976 55.8406 78.687 55.4425 78.7571 54.9178C78.8455 54.1588 78.8455 52.731 78.8455 51.0679V47.8878Z" fill="white"/>
                    <path d="M32.5011 56.1551C32.5011 56.1551 32.1099 56.1457 31.676 56.1551C30.9098 56.1727 29.9984 54.8237 29.9984 54.8237L29.6508 54.3582L29.8175 44.6095C29.8358 43.5913 29.978 43.2076 30.477 43.0625C30.6914 43.0065 30.8336 43.0065 31.0125 43.0065C31.2269 43.0065 31.3326 42.9536 31.3326 42.8427C31.3326 42.6975 31.1537 42.6788 30.921 42.6788C30.0502 42.6788 29.3724 42.7348 29.1753 42.7348C28.8003 42.7348 27.9468 42.6788 27.018 42.6788C26.7518 42.6788 26.5546 42.6975 26.5546 42.8427C26.5546 42.9536 26.6268 43.0065 26.8392 43.0065C27.0902 43.0065 27.5169 43.0065 27.7862 43.1174C28.213 43.2999 28.3735 43.6452 28.3908 44.7536L28.5697 52.919H28.4792C28.1764 52.6287 25.7712 50.0085 24.5579 48.7736C21.9586 46.1368 19.2516 43.1703 19.0362 42.936C18.8746 42.7618 18.6633 42.598 18.4712 42.4818C18.1735 42.2786 18.0586 42.3139 18.0586 42.3139H14.995C14.6698 42.3139 14.6403 42.7753 15.0458 42.8033C15.0458 42.8033 15.436 42.8126 15.8709 42.8033C16.6371 42.7856 17.5485 44.1346 17.5485 44.1346L18.1186 44.8998L17.9865 53.7547C17.9682 55.3349 17.8961 55.8627 17.4327 56.0078C17.1848 56.0814 16.8637 56.1001 16.631 56.1001C16.4521 56.1001 16.3464 56.1343 16.3464 56.2453C16.3464 56.4091 16.507 56.4278 16.7366 56.4278C17.6654 56.4278 18.5037 56.3718 18.6643 56.3718C19.0026 56.3718 19.714 56.4278 20.8724 56.4278C21.1233 56.4278 21.2839 56.3904 21.2839 56.2453C21.2839 56.1343 21.1752 56.1001 20.978 56.1001C20.6935 56.1001 20.3551 56.0814 20.0523 55.9705C19.6957 55.844 19.465 55.3712 19.4294 53.9548L19.2333 46.3141H19.2882C19.6093 46.6594 21.5877 48.9353 23.5296 50.8981C25.1341 52.5219 27.0597 54.5241 28.278 55.7413C28.4894 55.9757 28.6703 56.1499 28.8217 56.2784C29.0066 56.4672 29.2078 56.6434 29.3927 56.6434C29.4019 56.6434 29.408 56.6372 29.4171 56.6362C29.4659 56.6465 29.4893 56.6434 29.4893 56.6434H32.5529C32.8781 56.6434 32.9076 56.182 32.5021 56.154" fill="white"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_845_201">
                    <rect width="72" height="25" fill="white" transform="translate(14.7461 42.3115)"/>
                    </clipPath>
                    </defs>
                    </svg>
                `),
                scaledSize: new google.maps.Size(120, 70),
                anchor: new google.maps.Point(60, 70)
            }
        });

        // Create Singapore marker (blue circle)
        const singaporeMarker = new google.maps.Marker({
            position: window.nirupMapData.singapore,
            map: map,
            title: 'Singapore Ferry Terminal',
            icon: {
                url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="33" viewBox="0 0 25 33" fill="none">
                  <path d="M12.5 0C9.21928 0.00435195 6.07418 1.30954 3.75436 3.62936C1.43454 5.94918 0.129352 9.09428 0.125 12.375C0.125 21.2592 11.6544 32.3864 12.1442 32.8556C12.2395 32.9482 12.3671 33 12.5 33C12.6329 33 12.7605 32.9482 12.8558 32.8556C13.3456 32.3864 24.875 21.2592 24.875 12.375C24.8706 9.09428 23.5655 5.94918 21.2456 3.62936C18.9258 1.30954 15.7807 0.00435195 12.5 0ZM12.5 18.0469C11.3782 18.0469 10.2816 17.7142 9.34887 17.091C8.41614 16.4678 7.68916 15.5819 7.25987 14.5455C6.83058 13.5091 6.71826 12.3687 6.93711 11.2685C7.15596 10.1682 7.69615 9.15761 8.48938 8.36438C9.2826 7.57115 10.2932 7.03096 11.3935 6.81211C12.4937 6.59326 13.6341 6.70558 14.6705 7.13487C15.7069 7.56416 16.5928 8.29114 17.216 9.22388C17.8392 10.1566 18.1719 11.2532 18.1719 12.375C18.171 13.879 17.5731 15.3211 16.5096 16.3846C15.4461 17.4481 14.004 18.046 12.5 18.0469Z" fill="#22284F"/>
                </svg>
                `),
                scaledSize: new google.maps.Size(40, 50),
                anchor: new google.maps.Point(20, 50)
            }
        });

        // Create Batam marker (dark circle)
        const batamMarker = new google.maps.Marker({
            position: window.nirupMapData.batam,
            map: map,
            title: 'Batam Ferry Terminal',
            icon: {
                url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="33" viewBox="0 0 25 33" fill="none">
                  <path d="M12.5 0C9.21928 0.00435195 6.07418 1.30954 3.75436 3.62936C1.43454 5.94918 0.129352 9.09428 0.125 12.375C0.125 21.2592 11.6544 32.3864 12.1442 32.8556C12.2395 32.9482 12.3671 33 12.5 33C12.6329 33 12.7605 32.9482 12.8558 32.8556C13.3456 32.3864 24.875 21.2592 24.875 12.375C24.8706 9.09428 23.5655 5.94918 21.2456 3.62936C18.9258 1.30954 15.7807 0.00435195 12.5 0ZM12.5 18.0469C11.3782 18.0469 10.2816 17.7142 9.34887 17.091C8.41614 16.4678 7.68916 15.5819 7.25987 14.5455C6.83058 13.5091 6.71826 12.3687 6.93711 11.2685C7.15596 10.1682 7.69615 9.15761 8.48938 8.36438C9.2826 7.57115 10.2932 7.03096 11.3935 6.81211C12.4937 6.59326 13.6341 6.70558 14.6705 7.13487C15.7069 7.56416 16.5928 8.29114 17.216 9.22388C17.8392 10.1566 18.1719 11.2532 18.1719 12.375C18.171 13.879 17.5731 15.3211 16.5096 16.3846C15.4461 17.4481 14.004 18.046 12.5 18.0469Z" fill="#22284F"/>
                </svg>
                `),
                scaledSize: new google.maps.Size(40, 50),
                anchor: new google.maps.Point(20, 50)
            }
        });

        // console.log('✅ Custom markers created successfully');

        // Create info windows
        // const nirupInfo = new google.maps.InfoWindow({
        //     content: '<div style="font-family: Arial; padding: 5px;"><h4 style="margin: 0 0 5px 0;">Nirup Island</h4><p style="margin: 0;">Your luxury destination</p></div>'
        // });

        // const singaporeInfo = new google.maps.InfoWindow({
        //     content: '<div style="font-family: Arial; padding: 5px;"><h4 style="margin: 0 0 5px 0;">Singapore Terminal</h4><p style="margin: 0;">' + window.nirupMapData.singapore.info + '</p></div>'
        // });

        // const batamInfo = new google.maps.InfoWindow({
        //     content: '<div style="font-family: Arial; padding: 5px;"><h4 style="margin: 0 0 5px 0;">Batam Terminal</h4><p style="margin: 0;">' + window.nirupMapData.batam.info + '</p></div>'
        // });

        // Add click listeners
        // nirupMarker.addListener('click', function() {
        //     nirupInfo.open(map, nirupMarker);
        // });
        // singaporeMarker.addListener('click', function() {
        //     singaporeInfo.open(map, singaporeMarker);
        // });
        // batamMarker.addListener('click', function() {
        //     batamInfo.open(map, batamMarker);
        // });

        // --------- DOTTED ferry routes (white) ----------
        // Use a fully transparent base stroke and render dots via symbols only.
        // Squares instead of circles
        const squareSymbol = {
        // a 4×4 unit square centered on 0,0 (≈ 1 unit ≈ 1 px before scaling)
        path: 'M -2,-2 L 2,-2 L 2,2 L -2,2 Z',
        fillColor: '#ffffff',
        fillOpacity: 1,
        strokeOpacity: 0,   // set >0 for a white border
        // strokeColor: '#ffffff',
        // strokeWeight: 1,
        scale: 1.5,         // size knob (try 1–3)
        // fixedRotation: true, // uncomment to keep squares from rotating with the line
        };


        const singaporeRoute = new google.maps.Polyline({
            path: [window.nirupMapData.singapore, window.nirupMapData.center],
            geodesic: true,
            strokeColor: '#ffffff',
            strokeOpacity: 0,   // hide base line to avoid solid white
            strokeWeight: 0,
            icons: [{
                icon: squareSymbol,
                offset: '0',
                repeat: '12px'   // spacing between dots
            }],
            map: map
        });

        const batamRoute = new google.maps.Polyline({
            path: [window.nirupMapData.batam, window.nirupMapData.center],
            geodesic: true,
            strokeColor: '#ffffff',
            strokeOpacity: 0,   // hide base line to avoid solid white
            strokeWeight: 0,
            icons: [{
                icon: squareSymbol,
                offset: '0',
                repeat: '12px'   // spacing between dots
            }],
            map: map
        });
        // -----------------------------------------------

        // Add sailing boat icons on routes
        function getMidpoint(point1, point2) {
            return {
                lat: (point1.lat + point2.lat) / 2,
                lng: (point1.lng + point2.lng) / 2
            };
        }

        const singaporeBoat = new google.maps.Marker({
            position: getMidpoint(window.nirupMapData.singapore, window.nirupMapData.center),
            map: map,
            icon: {
                url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                <svg xmlns="http://www.w3.org/2000/svg" width="84" height="86" viewBox="0 0 84 86" fill="none">
                  <!-- (SVG content unchanged) -->
                </svg>
                `),
                scaledSize: new google.maps.Size(30, 30),
                anchor: new google.maps.Point(15, 15)
            },
            title: 'Ferry Route to Singapore'
        });

        const batamBoat = new google.maps.Marker({
            position: getMidpoint(window.nirupMapData.batam, window.nirupMapData.center),
            map: map,
            icon: {
                url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                <svg xmlns="http://www.w3.org/2000/svg" width="84" height="86" viewBox="0 0 84 86" fill="none">
                  <!-- (SVG content unchanged) -->
                </svg>
                `),
                scaledSize: new google.maps.Size(30, 30),
                anchor: new google.maps.Point(15, 15)
            },
            title: 'Ferry Route to Batam'
        });

        // Fit map to show all locations
        const bounds = new google.maps.LatLngBounds();
        bounds.extend(window.nirupMapData.center);
        bounds.extend(window.nirupMapData.singapore);
        bounds.extend(window.nirupMapData.batam);
        map.fitBounds(bounds);

        // Store references globally for controls
        window.nirupMapInstance = {
            map: map,
            markers: {
                nirup: nirupMarker,
                singapore: singaporeMarker,
                batam: batamMarker
            },
            routes: {
                singapore: singaporeRoute,
                batam: batamRoute
            },
            boats: {
                singapore: singaporeBoat,
                batam: batamBoat
            },
            bounds: bounds
        };

        // console.log('✅ CUSTOM MAP fully initialized with branded markers and routes');

    } catch (error) {
        console.error('❌ Error initializing map:', error);
    }
};

// Route control functions
function showSingaporeRoute() {
    if (window.nirupMapInstance) {
        window.nirupMapInstance.routes.singapore.setMap(window.nirupMapInstance.map);
        window.nirupMapInstance.routes.batam.setMap(null);
        window.nirupMapInstance.boats.singapore.setMap(window.nirupMapInstance.map);
        window.nirupMapInstance.boats.batam.setMap(null);
        
        const bounds = new google.maps.LatLngBounds();
        bounds.extend(window.nirupMapData.singapore);
        bounds.extend(window.nirupMapData.center);
        window.nirupMapInstance.map.fitBounds(bounds);
    }
}

function showBatamRoute() {
    if (window.nirupMapInstance) {
        window.nirupMapInstance.routes.batam.setMap(window.nirupMapInstance.map);
        window.nirupMapInstance.routes.singapore.setMap(null);
        window.nirupMapInstance.boats.batam.setMap(window.nirupMapInstance.map);
        window.nirupMapInstance.boats.singapore.setMap(null);
        
        const bounds = new google.maps.LatLngBounds();
        bounds.extend(window.nirupMapData.batam);
        bounds.extend(window.nirupMapData.center);
        window.nirupMapInstance.map.fitBounds(bounds);
    }
}

function showAllRoutes() {
    if (window.nirupMapInstance) {
        window.nirupMapInstance.routes.singapore.setMap(window.nirupMapInstance.map);
        window.nirupMapInstance.routes.batam.setMap(window.nirupMapInstance.map);
        window.nirupMapInstance.boats.singapore.setMap(window.nirupMapInstance.map);
        window.nirupMapInstance.boats.batam.setMap(window.nirupMapInstance.map);
        window.nirupMapInstance.map.fitBounds(window.nirupMapInstance.bounds);
    }
}

// Error handling
window.gm_authFailure = function() {
    console.error('❌ Google Maps authentication failed');
    const mapElement = document.getElementById('nirup-ferry-map');
    if (mapElement) {
        mapElement.innerHTML = `
            <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: #f5f5f5; color: #666; text-align: center; padding: 20px; border-radius: 20px;">
                <div>
                    <h4 style="margin: 0 0 10px 0;">Google Maps Error</h4>
                    <p style="margin: 0;">Please check your API key settings</p>
                </div>
            </div>
        `;
    }
};

// DOM Ready functions
document.addEventListener('DOMContentLoaded', function() {
    // console.log('✅ DOM loaded, setting up CUSTOM controls');
    
    // Set up route controls
    const controlButtons = document.querySelectorAll('.map-control-btn');
    controlButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const route = this.getAttribute('data-route');
            
            // Update active state
            controlButtons.forEach(function(btn) {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            
            // Show/hide routes
            switch(route) {
                case 'singapore':
                    showSingaporeRoute();
                    break;
                case 'batam':
                    showBatamRoute();
                    break;
                case 'all':
                default:
                    showAllRoutes();
                    break;
            }
        });
    });

    // Simple scroll animation
    const mapContainer = document.querySelector('.getting-here-map-container');
    const scheduleItems = document.querySelectorAll('.schedule-item');
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        if (mapContainer) {
            mapContainer.style.opacity = '0';
            mapContainer.style.transform = 'translateY(30px)';
            mapContainer.style.transition = 'all 0.8s ease';
            observer.observe(mapContainer);
        }

        scheduleItems.forEach(function(item, index) {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'all 0.6s ease';
            item.style.transitionDelay = (index * 0.1) + 's';
            observer.observe(item);
        });
    }
});

// console.log('✅ CUSTOM Getting Here script loaded successfully');
