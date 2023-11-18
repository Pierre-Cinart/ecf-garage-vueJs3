document.addEventListener('DOMContentLoaded', function () {
    var carMarkSelect = document.getElementById('car_mark');
    var newMarkInput = document.getElementById('newMarkInput');
    var carColorSelect = document.getElementById('car_color');
    var newColorInput = document.getElementById('newColorInput');

    carMarkSelect.addEventListener('change', function () {
        if (carMarkSelect.value === 'Autre') {
            newMarkInput.style.display = 'inline-block';
        } else {
            newMarkInput.style.display = 'none';
        }
    });

    carColorSelect.addEventListener('change', function () {
        if (carColorSelect.value === 'Autre') {
            newColorInput.style.display = 'inline-block';
        } else {
            newColorInput.style.display = 'none';
        }
    });
});
