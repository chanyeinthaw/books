import {usePage} from "@inertiajs/inertia-react";
import {useEffect} from "react";
import {useSnackbar} from "notistack";

export default function useNotificationStack() {
    let { flash } = usePage().props
    let { enqueueSnackbar } = useSnackbar()

    useEffect(() => {
        if (flash?.message) enqueueSnackbar(flash.message, { variant: 'info', persist: false })
        else if (flash?.error) enqueueSnackbar(flash.error.message, { variant: 'error', persist: false })
    }, [])
}