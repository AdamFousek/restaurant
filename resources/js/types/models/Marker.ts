import MarkerTooltip from "@/types/models/partials/MarkerTooltip";

export default interface Marker {
    date: string
    type: string
    tooltip: MarkerTooltip[]
}