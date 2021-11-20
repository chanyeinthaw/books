import {usePage} from "@inertiajs/inertia-react";
import {useEffect} from "react";
import {useSnackbar} from "notistack";

export default function useNotificationStack() {
    let { flash, errors } = usePage().props
    let { enqueueSnackbar } = useSnackbar()

    useEffect(() => {
        if (flash?.message) enqueueSnackbar(flash.message.message, { variant: 'info', persist: false })
        else if (flash?.error) enqueueSnackbar(flash.error.message, { variant: 'error', persist: false })

        if (Array.isArray(errors)) errors.map(error => enqueueSnackbar(error, { variant: 'error', persist: false }))
    }, [])
}