import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { useForm, Head } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import Chirp from "@/Components/Chirp";

export default function Index({ auth, chirps }) {
    const { data, setData, post, processing, reset, errors } = useForm({
        message: "",
    });
    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("chirps.store"), {
            onSuccess: () => reset(),
        });
    };
    return (
        <AuthenticatedLayout auth={auth}>
            <Head title="Chirps" />
            <div className="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
                <form onSubmit={handleSubmit}>
                    <textarea
                        name=""
                        id=""
                        cols="30"
                        rows="7"
                        value={data.message}
                        placeholder="What's on your mind?"
                        className="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        onChange={(e) => setData("message", e.target.value)}
                    ></textarea>
                    <InputError message={errors.message} className="mt-2" />
                    <PrimaryButton className="mt-4" disabled={processing}>
                        Chirp
                    </PrimaryButton>
                </form>
                <div className="mt-6 bg-white shadow-sm rounded-lg divide-y">
                    {chirps.map((chirp) => (
                        <Chirp chirp={chirp} key={chirp.id} />
                    ))}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
