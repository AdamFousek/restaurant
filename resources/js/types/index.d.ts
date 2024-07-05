export interface User {
    id: number;
    firstName: string;
    lastName: string;
    phoneNumber: string;
    email: string;
    email_verified_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        isAuth: boolean;
        user: User;
    };
    flash: {
        alert: {
            type: string
            header: string
            message: string
        }
    }
};
