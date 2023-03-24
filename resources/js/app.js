import "./bootstrap";

import dayjs from "dayjs";

import Alpine from "alpinejs";
import NotificationsAlpinePlugin from "../../vendor/filament/notifications/dist/module.esm";

Alpine.plugin(NotificationsAlpinePlugin);

window.dayjs = dayjs;
window.Alpine = Alpine;

Alpine.start();
