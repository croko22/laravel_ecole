import "./bootstrap";
import "flowbite";
import { initFlowbite } from "flowbite";

document.addEventListener("livewire:navigating", () => {
    initFlowbite();
});
