#!/bin/bash
clear
echo "========================================================"
echo "          MENYALAKAN SEMUA MESIN COFFEE SHOP..."
echo "========================================================"
echo "Membuka 4 tab terminal pelayan secara otomatis:"
echo "- Server Web Utama (8000)"
echo "- Mesin Visual (Tailwind UI)"
echo "- Radar Notifikasi (Reverb WebSocket)"
echo "- Pekerja Latar Belakang (Queue)"
echo "========================================================"

cd "$(dirname "$0")/.."

# Buka Server Web di tab baru
osascript -e 'tell app "Terminal"
    do script "cd \"'"$(pwd)"'\" && echo \"== SERVER WEB ==\" && php artisan serve"
end tell'

# Buka Webpack/Vite UI di tab baru
osascript -e 'tell app "Terminal"
    do script "cd \"'"$(pwd)"'\" && echo \"== MESIN VISUAL ==\" && npm run dev"
end tell'

# Buka WebSocket Reverb di tab baru
osascript -e 'tell app "Terminal"
    do script "cd \"'"$(pwd)"'\" && echo \"== RADAR WEBSOCKET ==\" && php artisan reverb:start"
end tell'

# Buka Queue/Pekerja di tab baru
osascript -e 'tell app "Terminal"
    do script "cd \"'"$(pwd)"'\" && echo \"== PEKERJA BACKGROUND ==\" && php artisan queue:listen"
end tell'

echo ""
echo "SUKSES! Semua mesin telah dihidupkan pada jendela baru."
echo "Silakan buka Chrome dan akses: http://localhost:8000"
echo "Jendela ini boleh ditutup."
echo "========================================================"
exit 0
