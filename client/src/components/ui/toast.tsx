import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const toastify = () => {
    const notifySuccess = (message) => {
        toast.success(`${message} !`, {
            autoClose: 1500,
        }); // ToastOptions
    };

    const notifyError = (message) => {
        toast.error(`${message}`, {
            autoClose: 1500,
        }); // ToastOptions
    };

    return { notifySuccess, notifyError }
}

export default toastify