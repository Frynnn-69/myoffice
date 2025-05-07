export interface Office {
    id: number,
    price: number,
    duration: number,
    name: string,
    slug: string,
    city: City, // mengambil data city dari interface City
    thumbnail: string,
    photos: Photo[], // menggunakan [] karena ada banyak foto
    benefits: Benefit[],
    about: string,
}

export interface City {
    id: number,
    name: string,
    slug: string,
    photo: string,
    office_spaces_count: number,
    officeSpaces: Office[],
}

interface Photo {
    id: number,
    photo: string,
}

interface Benefit {
    id: number,
    name: string,
}

export interface BookingDetails{
    id: number,
    name: string,
    phone_number: string,
    booking_trx_id: string,
    is_paid: boolean,
    duration: number,
    total_amount: number,
    started_date: string,
    ended_date: string,
    office: Office,
}

