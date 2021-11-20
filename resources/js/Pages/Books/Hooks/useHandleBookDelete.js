import {Inertia} from "@inertiajs/inertia";

export default function useHandleBookDelete() {
    return (id) => {
        Inertia.delete(route('books.delete', [id]), {
            replace: true,
            preserveState: true
        })
    }
}