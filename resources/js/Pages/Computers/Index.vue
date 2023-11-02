<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import WarningButton from "@/Components/WarningButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";
import Swal from "sweetalert2";
import VueTailwindPagination from "@ocrv/vue-tailwind-pagination";

const nameInput = ref(null);
const modal = ref(false);
const title = ref("");
const operation = ref(1);
const id = ref("");

const props = defineProps({
    computers: { type: Object },
    dependencies: { type: Object },
});
const form = useForm({
    name: "",
    so: "",
    ofimatica: "",
    cpu: "",
    storage: "",
    ram: "",
    ip: "",
    mac: "",
    serial: "",
    fixed_asset: "",
    anydesk: "",
    printer: "",
    scanner: "",
    dependencie_id: "",
});
const formPage = useForm({});
const onPageClick = (event) => {
    formPage.get(route("computers.index", { page: event }));
};
const openModal = (
    op,
    name,
    so,
    ofimatica,
    cpu,
    storage,
    ram,
    ip,
    mac,
    serial,
    fixed_asset,
    anydesk,
    printer,
    scanner,
    dependencie,
    computer
) => {
    modal.value = true;
    nextTick(() => nameInput.value.focus());
    operation.value = op;
    id.value = computer;
    if (op == 1) {
        title.value = "Crear equipo";
    } else {
        title.value = "Editar equipo";
        form.name = name;
        form.so = so;
        form.ofimatica = ofimatica;
        form.cpu = cpu;
        form.storage = storage;
        form.ram = ram;
        form.ip = ip;
        form.mac = mac;
        form.serial = serial;
        form.fixed_asset = fixed_asset;
        form.anydesk = anydesk;
        form.printer = printer;
        form.scanner = scanner;
        form.dependencie_id = dependencie;
    }
};
const closeModal = () => {
    modal.value = false;
    form.reset();
};
const save = () => {
    if (operation.value == 1) {
        form.post(route("computers.store"), {
            onSuccess: () => {
                ok("Equipo creado");
            },
        });
    } else {
        form.put(route("computers.update", id.value), {
            onSuccess: () => {
                ok("Equipo actualizado");
            },
        });
    }
};
const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({ title: msj, icon: "success" });
};
const deleteComputer = (id, name) => {
    const alerta = Swal.mixin({
        buttonsStyling: true,
    });
    alerta
        .fire({
            title: "Are you sure delete " + name + " ?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: '<i class="fa-solid fa-check"></i> Yes,delete',
            cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancel',
        })
        .then((result) => {
            if (result.isConfirmed) {
                form.delete(route("computers.destroy", id), {
                    onSuccess: () => {
                        ok("Equipo eliminado");
                    },
                });
            }
        });
};
</script>

<template>
    <Head title="Equipos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Equipos
            </h2>
        </template>

        <div class="py-12 p-4">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i> Agregar
                    </PrimaryButton>
                </div>
            </div>
            <div
                class="bg-white grid v-screen place-items-center overflow-x-auto py-3 p-8"
            >
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">#</th>
                            <th class="px-2 py-2">NAME</th>
                            <th class="px-2 py-2">SO</th>
                            <th class="px-2 py-2">OFIMATICA</th>
                            <th class="px-2 py-2">CPU</th>
                            <th class="px-2 py-2">STORAGE</th>
                            <th class="px-2 py-2">RAM</th>
                            <th class="px-2 py-2">IP</th>
                            <th class="px-2 py-2">MAC</th>
                            <th class="px-2 py-2">SERIAL</th>
                            <th class="px-2 py-2">FIXED_ASSET</th>
                            <th class="px-2 py-2">ANYDESK</th>
                            <th class="px-2 py-2">PRINTER</th>
                            <th class="px-2 py-2">SCANNER</th>
                            <th class="px-2 py-2">DEPENDENCIA</th>
                            <th class="px-2 py-2"></th>
                            <th class="px-2 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(com, i) in computers.data" :key="com.id">
                            <td class="border border-gray-400 px-2 py-2">
                                {{ i + 1 }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ com.name }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ com.so }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ com.ofimatica }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ com.cpu }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ com.storage }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ com.ram }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ com.ip }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ com.mac }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ com.serial }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ com.fixed_asset }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ com.anydesk }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ com.printer }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ com.scanner }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                {{ com.dependencie }}
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <WarningButton
                                    @click="
                                        openModal(
                                            2,
                                            com.name,
                                            com.so,
                                            com.ofimatica,
                                            com.cpu,
                                            com.storage,
                                            com.ram,
                                            com.ip,
                                            com.mac,
                                            com.serial,
                                            com.fixed_asset,
                                            com.anydesk,
                                            com.printer,
                                            com.scanner,
                                            com.dependencie_id,
                                            com.id
                                        )
                                    "
                                >
                                    <i class="fa-solid fa-edit"></i>
                                </WarningButton>
                            </td>
                            <td class="border border-gray-400 px-2 py-2">
                                <DangerButton
                                    @click="deleteComputer(com.id, com.name)"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <VueTailwindPagination
                    :current="computers.currentPage"
                    :total="computers.total"
                    :per-page="computers.perPage"
                    @page-changed="onPageClick($event)"
                ></VueTailwindPagination>
            </div>
        </div>
        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3 mt-6">
                <InputLabel for="name" value="Name:"></InputLabel>
                <TextInput
                    id="name"
                    ref="nameInput"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Name"
                ></TextInput>
                <InputError
                    :message="form.errors.name"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="so" value="Sistema Operativo:"></InputLabel>
                <TextInput
                    id="so"
                    v-model="form.so"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Sistema Operativo"
                ></TextInput>
                <InputError
                    :message="form.errors.email"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="ofimatica" value="Ofimatica:"></InputLabel>
                <TextInput
                    id="ofimatica"
                    v-model="form.ofimatica"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Ofimatica"
                ></TextInput>
                <InputError
                    :message="form.errors.phone"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="cpu" value="Cpu:"></InputLabel>
                <TextInput
                    id="cpu"
                    v-model="form.cpu"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Cpu"
                ></TextInput>
                <InputError
                    :message="form.errors.cpu"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="storage" value="Almacenamiento:"></InputLabel>
                <TextInput
                    id="storage"
                    v-model="form.storage"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Almacenamiento"
                ></TextInput>
                <InputError
                    :message="form.errors.storage"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="ram" value="Ram:"></InputLabel>
                <TextInput
                    id="ram"
                    v-model="form.ram"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Ram"
                ></TextInput>
                <InputError
                    :message="form.errors.ram"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="ip" value="Ip:"></InputLabel>
                <TextInput
                    id="ip"
                    v-model="form.ip"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Ip"
                ></TextInput>
                <InputError
                    :message="form.errors.ip"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="mac" value="Mac:"></InputLabel>
                <TextInput
                    id="mac"
                    v-model="form.mac"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Mac"
                ></TextInput>
                <InputError
                    :message="form.errors.mac"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="serial" value="Serial:"></InputLabel>
                <TextInput
                    id="serial"
                    v-model="form.serial"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Serial"
                ></TextInput>
                <InputError
                    :message="form.errors.serial"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="activo" value="Activo fijo:"></InputLabel>
                <TextInput
                    id="activo"
                    v-model="form.fixed_asset"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Activo fijo"
                ></TextInput>
                <InputError
                    :message="form.errors.fixed_asset"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="anydesk" value="Anydesk"></InputLabel>
                <TextInput
                    id="anydesk"
                    v-model="form.anydesk"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Anydesk"
                ></TextInput>
                <InputError
                    :message="form.errors.fixed_asset"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="impresora" value="Impresora"></InputLabel>
                <TextInput
                    id="impresora"
                    v-model="form.printer"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Impresora"
                ></TextInput>
                <InputError
                    :message="form.errors.printer"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="escaner" value="Escaner"></InputLabel>
                <TextInput
                    id="escaner"
                    v-model="form.scanner"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Escaner"
                ></TextInput>
                <InputError
                    :message="form.errors.scanner"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3">
                <InputLabel
                    for="dependencie_id"
                    value="Dependencia:"
                ></InputLabel>
                <SelectInput
                    id="dependencie_id"
                    :options="dependencies"
                    v-model="form.dependencie_id"
                    type="text"
                    class="mt-1 block w-3/4"
                ></SelectInput>
                <InputError
                    :message="form.errors.dependencie_id"
                    class="mt-2"
                ></InputError>
            </div>
            <div class="p-3 mt-6">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Save
                </PrimaryButton>
            </div>
            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton
                    class="ml-3"
                    :disabled="form.processing"
                    @click="closeModal"
                >
                    Cancel
                </SecondaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
