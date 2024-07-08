import MarkerTooltip from "@/types/models/partials/MarkerTooltip";

export default interface Marker {
    day: string
    type: string
    tooltip: MarkerTooltip[]
}