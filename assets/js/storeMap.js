import { showToast } from "./toast.js";

const select = document.getElementById('coso');
const map = document.getElementById('map');
const btnFindNear = document.getElementById('btnFindNear');
const btnMyLocation = document.getElementById('btnMyLocation');

const stores = {
    hn: { lat: 21.03619, lng: 105.81382, name: "Hà Nội", map: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.863655820695!2d105.8116358154145!3d21.036194885994247!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab7d7d8db4e7%3A0x78e7685e46d7e5b5!2zMjY2IMSQLiDEkOG7i2kgQ8OgbiwgQmEgxJDDrG5oLCBIw6AgTuG7mWksIFZpZXRuYW0!5e0!3m2!1svi!2s!4v1698222400000!5m2!1svi!2s" },
    hcm: { lat: 10.77482, lng: 106.69019, name: "Hồ Chí Minh", map: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.669654496263!2d106.68800507460309!3d10.774820592317847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3f6d0a5a03%3A0x8b4a62f9a63b1d02!2zMjQ1IE5ndXnhu4VuIFRo4buLIE1pbmggS2hhaSwgUGjGsOG7nW5nIDEsIFF14bqtbiAxLCBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1698222551111!5m2!1svi!2s" },
    dn: { lat: 16.07213, lng: 108.21895, name: "Đà Nẵng", map: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3833.838073115744!2d108.21703071486747!3d16.07213088887365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314219f0b85cf2e7%3A0xbdd3f78a8eecb3c1!2zOTcgTMOqIEzhu6NpLCBI4bqjaSBDaMOidSwgxJDDoCBO4bqvbmcsIFZpZXRuYW0!5e0!3m2!1svi!2s!4v1698222602222!5m2!1svi!2s" },
    ct: { lat: 10.03689, lng: 105.78964, name: "Cần Thơ", map: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.841518315751!2d105.78744631473995!3d10.036888992821099!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a08947ac0123c7%3A0xfed2d8d9a4a2f676!2zNjggVHLhuqduIEjGsG5nIMSQ4bqhaSwgTmluaCBLaeG7gXUsIEPhuqduIFRow7RuLCBWaWV0bmFt!5e0!3m2!1svi!2s!4v1698222703333!5m2!1svi!2s" },
    hp: { lat: 20.86481, lng: 106.68226, name: "Hải Phòng", map: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.3032599998847!2d106.68004031503592!3d20.864811986086678!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3141a14839bfffb7%3A0xabcdd41e5fddc7e1!2zMTIgxJDhu4tuaCBCacOqbiBQaMO6LCBOZ8ahIFF1eeG7gW4sIEjhuqNpIFBow7JuZywgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1698222804444!5m2!1svi!2s" }
};

// Hàm tính khoảng cách chuẩn Haversine
function calcDistance(lat1, lng1, lat2, lng2) {
    const R = 6371; // Bán kính trái đất km
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLng = (lng2 - lng1) * Math.PI / 180;
    const a = Math.sin(dLat/2)**2 + Math.cos(lat1 * Math.PI/180) * Math.cos(lat2 * Math.PI/180) * Math.sin(dLng/2)**2;
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
}

function updateMap(code) {
    map.src = stores[code].map;
}

select.addEventListener('change', e => updateMap(e.target.value));

btnFindNear.addEventListener('click', () => {
    if (!navigator.geolocation) {
       showToast("Trình duyệt không hỗ trợ định vị!");
       return;
    }

    btnFindNear.classList.add("btn-loading");

    navigator.geolocation.getCurrentPosition(
        pos => {
            const { latitude, longitude } = pos.coords;
            let nearest = null, minDist = Infinity;

            for (const [id, s] of Object.entries(stores)) {
                const dist = calcDistance(latitude, longitude, s.lat, s.lng);
                if (dist < minDist) minDist = dist, nearest = id;
            }

            // Đặt select về cửa hàng gần nhất
            select.value = nearest;

            // Đổi map sang đúng vị trí cửa hàng gần nhất
            map.src = `https://www.google.com/maps?q=${stores[nearest].lat},${stores[nearest].lng}&z=15&output=embed`;

            showToast(`Gần bạn nhất: ${stores[nearest].name} (${minDist.toFixed(1)} km)`, "info");
            btnFindNear.classList.remove("btn-loading");
        },
        () => {
            showToast("Không thể truy cập vị trí. Hãy bật GPS!", "error");
            btnFindNear.classList.remove("btn-loading");
        }
    );
});


updateMap('hn');
let userPos = null;

// Vị trí của tôi
btnMyLocation.addEventListener('click', () => {
    btnMyLocation.classList.add('btn-loading');
    if (!navigator.geolocation) {
        showToast("Trình duyệt không hỗ trợ định vị!");
        btnMyLocation.classList.remove('btn-loading');
        return;
    }

    navigator.geolocation.getCurrentPosition(pos => {
        const { latitude, longitude } = pos.coords;
        userPos = { lat: latitude, lng: longitude };

        map.src = `https://www.google.com/maps?q=${latitude},${longitude}&z=15&output=embed`;

        showToast("Đã xác định vị trí của bạn", "success");
        btnMyLocation.classList.remove('btn-loading');
    }, () => {
        showToast("Không thể truy cập vị trí. Hãy bật GPS!", "error");
        btnMyLocation.classList.remove('btn-loading');
    });
});

// Chỉ đường từ vị trí của bạn → cơ sở đang chọn
document.getElementById('btnDirection').addEventListener('click', () => {
    if (!userPos) {
        showToast("Hãy nhấn 'Vị trí của tôi' trước!", "warning");
        return;
    }

    const code = select.value;
    const store = stores[code];

    if (!store) {
        showToast("Hãy chọn cơ sở!", "warning");
        return;
    }

    // Mở Google Maps chỉ đường
    window.open(`https://www.google.com/maps/dir/${userPos.lat},${userPos.lng}/${store.lat},${store.lng}`, "_blank");
});