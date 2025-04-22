import z, { ZodObject } from 'zod';
import { ref, watch } from 'vue';

const useForm = <T extends z.ZodObject<any>>(schema: z.ZodObject<any, any>, info: any, errors: any) => {

    const data = ref<T>(info)

    // Thêm function để reset form
    const reset = () => {
        data.value = {} as z.infer<typeof schema>;
        errors.value = {};
    };


    const setError = (field: keyof z.infer<typeof schema>, message: string) => {
        errors.value[field] = message;
    };

    const validateField = (fieldName: keyof z.infer<typeof schema>) => {
        try {
            const fieldSchema = z.object({ [fieldName]: schema.shape[fieldName] });
            fieldSchema.parse({ [fieldName]: info.value[fieldName] });
            errors.value[fieldName] = '';
        } catch (error) {
            if (error instanceof z.ZodError) {
                const fieldError = error.errors[0];
                switch (fieldError.code) {
                    case 'invalid_type':
                        errors.value[fieldName] = schema.shape[fieldName]._def.required_error || fieldError.message;
                        break;
                    default:
                        errors.value[fieldName] = fieldError.message;
                }
            }
        }
    };

    const validateForm = (): boolean => {
        try {
            schema.parse(data.value);
            errors.value = {};
            return true;
        } catch (error) {
            if (error instanceof z.ZodError) {
                errors.value = {};

                error.errors.forEach((err) => {
                    errors.value[err.path[0]] = err.message;
                    console.error(`Validation error in field ${err.path[0]}: ${err.message}`);
                    console.error(`Validation error in field ${errors.value}`);
                });
            }
            return false;
        }
    };

    watch(
        () => data.value,
        () => {
            Object.keys(data.value).forEach((field) => {
                validateField(field as keyof z.infer<typeof schema>);
            });
        },
        { deep: true }
    );

    return { reset, errors, setError, watch, validateField, validateForm }
}

export default useForm