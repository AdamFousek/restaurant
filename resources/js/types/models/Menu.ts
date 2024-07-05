import Food from "@/types/models/partials/Food";

export default interface Menu {
    menu: {
        soup: Food
        main: Food
    }
    date: string,
    dayName: string
}