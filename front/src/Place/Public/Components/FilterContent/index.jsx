/* eslint-disable react/prop-types */
// import { useState, useEffect } from "react";

// import { CgShoppingBag, CgCheckO } from "react-icons/cg";

// import { useCartContext } from "../../Hooks/useCartContext";
// import { useCart } from "../../Hooks/useCart";
import { Disclosure } from "@headlessui/react";
import { useKeyDown } from "../../Hooks/useKeyDown";
import { MinusIcon, PlusIcon } from "@heroicons/react/24/outline";

// import CartItem from "../../Pages/Cart/CartItem";

// import Button from "../Button";
// import Toast from "../Toast";
// import ToastMessage from "../ToastMessage";

// import { addAllItemsPrice } from "../../helpers/item";

// import styles from "./index.module.scss";

const FilterContent = ({ toggleFilterModal }) => {
    useKeyDown(() => {
        toggleFilterModal();
    }, ["Escape"]);
    const colors = [
        {
            id: "color",
            name: "Color",
            options: [
                { value: "White", label: "White", checked: false },
                { value: "Black", label: "Black", checked: false },
                { value: "Blue", label: "Blue", checked: false },
                { value: "Red", label: "Red", checked: false },
                { value: "Green", label: "Green", checked: false },
                { value: "Purple", label: "Purple", checked: false },
            ],
        },
    ];

    const categories = [
        {
            id: "category",
            name: "Size",
            options: [
                { value: "Originals", label: "Originals", checked: false },
                { value: "Sneakers", label: "Sneakers", checked: false },
                { value: "Running", label: "Running", checked: false },
                { value: "Basketball", label: "Basketball", checked: false },
            ],
        },
    ];
    return (
        <div className=" overflow-scroll w-full h-full flex items-center justify-center z-50 relative ">
            <form className=" mt-6  border-gray-200 w-full p-10">
                <h3 className="sr-only">Categories</h3>
                {/* <ul role="list" className="px-2 py-3 font-medium text-gray-900">
                    {subCategories.map((category) => (
                        <li key={category.name}>
                            <a href={category.href} className="block px-2 py-3">
                                {category.name}
                            </a>
                        </li>
                    ))}
                </ul> */}
                    {/* category-list */}

                {colors.map((section) => (
                    <Disclosure
                        as="div"
                        key={section.id}
                        className="border-t border-gray-200 px-4 py-6"
                    >
                        {({ open }) => (
                            <>
                                <h3 className="-mx-2 -my-3 flow-root">
                                    <Disclosure.Button className="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                        <span className="font-medium text-gray-900">
                                            {section.name}
                                        </span>
                                        <span className="ml-6 flex items-center">
                                            {open ? (
                                                <MinusIcon
                                                    className="h-5 w-5"
                                                    aria-hidden="true"
                                                />
                                            ) : (
                                                <PlusIcon
                                                    className="h-5 w-5"
                                                    aria-hidden="true"
                                                />
                                            )}
                                        </span>
                                    </Disclosure.Button>
                                </h3>
                                <Disclosure.Panel className="pt-6">
                                    <div className="space-y-4">
                                        {section.options.map(
                                            (option, optionIdx) => (
                                                <div
                                                    key={option.value}
                                                    className="flex items-center"
                                                >
                                                    <input
                                                        id={`filter-${section.id}-${optionIdx}`}
                                                        name={`${section.id}[]`}
                                                        defaultValue={
                                                            option.value
                                                        }
                                                        type="checkbox"
                                                        defaultChecked={
                                                            option.checked
                                                        }
                                                        className="h-4 w-4 rounded border-gray-300 text-dark-blue focus:ring-green"
                                                        // onClick={(e) => handleColor(e, optionIdx)}
                                                    />
                                                    <label
                                                        htmlFor={`filter-${section.id}-${optionIdx}`}
                                                        className="ml-3 min-w-0 flex-1 text-gray-500"
                                                    >
                                                        {option.label}
                                                    </label>
                                                </div>
                                            )
                                        )}
                                    </div>
                                </Disclosure.Panel>
                            </>
                        )}
                    </Disclosure>
                ))}

                {categories.map((section) => (
                    <Disclosure
                        as="div"
                        key={section.id}
                        className="border-t border-gray-200 px-4 py-6"
                    >
                        {({ open }) => (
                            <>
                                <h3 className="-mx-2 -my-3 flow-root">
                                    <Disclosure.Button className="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                        <span className="font-medium text-gray-900">
                                            {section.name}
                                        </span>
                                        <span className="ml-6 flex items-center">
                                            {open ? (
                                                <MinusIcon
                                                    className="h-5 w-5"
                                                    aria-hidden="true"
                                                />
                                            ) : (
                                                <PlusIcon
                                                    className="h-5 w-5"
                                                    aria-hidden="true"
                                                />
                                            )}
                                        </span>
                                    </Disclosure.Button>
                                </h3>
                                <Disclosure.Panel className="pt-6">
                                    <div className="space-y-4">
                                        {section.options.map(
                                            (option, optionIdx) => (
                                                <div
                                                    key={option.value}
                                                    className="flex items-center"
                                                >
                                                    <input
                                                        id={`filter-${section.id}-${optionIdx}`}
                                                        name={`${section.id}[]`}
                                                        defaultValue={
                                                            option.value
                                                        }
                                                        type="checkbox"
                                                        defaultChecked={
                                                            option.checked
                                                        }
                                                        className="h-4 w-4 rounded border-gray-300 text-dark-blue focus:ring-green"
                                                        // onClick={(e) => handleColor(e, optionIdx)}
                                                    />
                                                    <label
                                                        htmlFor={`filter-${section.id}-${optionIdx}`}
                                                        className="ml-3 min-w-0 flex-1 text-gray-500"
                                                    >
                                                        {option.label}
                                                    </label>
                                                </div>
                                            )
                                        )}
                                    </div>
                                </Disclosure.Panel>
                            </>
                        )}
                    </Disclosure>
                ))}
                {colors.map((section) => (
                    <Disclosure
                        as="div"
                        key={section.id}
                        className="border-t border-gray-200 px-4 py-6"
                    >
                        {({ open }) => (
                            <>
                                <h3 className="-mx-2 -my-3 flow-root">
                                    <Disclosure.Button className="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                        <span className="font-medium text-gray-900">
                                            {section.name}
                                        </span>
                                        <span className="ml-6 flex items-center">
                                            {open ? (
                                                <MinusIcon
                                                    className="h-5 w-5"
                                                    aria-hidden="true"
                                                />
                                            ) : (
                                                <PlusIcon
                                                    className="h-5 w-5"
                                                    aria-hidden="true"
                                                />
                                            )}
                                        </span>
                                    </Disclosure.Button>
                                </h3>
                                <Disclosure.Panel className="pt-6">
                                    <div className="space-y-4">
                                        {section.options.map(
                                            (option, optionIdx) => (
                                                <div
                                                    key={option.value}
                                                    className="flex items-center"
                                                >
                                                    <input
                                                        id={`filter-${section.id}-${optionIdx}`}
                                                        name={`${section.id}[]`}
                                                        defaultValue={
                                                            option.value
                                                        }
                                                        type="checkbox"
                                                        defaultChecked={
                                                            option.checked
                                                        }
                                                        className="h-4 w-4 rounded border-gray-300 text-dark-blue focus:ring-green"
                                                        // onClick={(e) => handleColor(e, optionIdx)}
                                                    />
                                                    <label
                                                        htmlFor={`filter-${section.id}-${optionIdx}`}
                                                        className="ml-3 min-w-0 flex-1 text-gray-500"
                                                    >
                                                        {option.label}
                                                    </label>
                                                </div>
                                            )
                                        )}
                                    </div>
                                </Disclosure.Panel>
                            </>
                        )}
                    </Disclosure>
                ))}

                {categories.map((section) => (
                    <Disclosure
                        as="div"
                        key={section.id}
                        className="border-t border-gray-200 px-4 py-6"
                    >
                        {({ open }) => (
                            <>
                                <h3 className="-mx-2 -my-3 flow-root">
                                    <Disclosure.Button className="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                        <span className="font-medium text-gray-900">
                                            {section.name}
                                        </span>
                                        <span className="ml-6 flex items-center">
                                            {open ? (
                                                <MinusIcon
                                                    className="h-5 w-5"
                                                    aria-hidden="true"
                                                />
                                            ) : (
                                                <PlusIcon
                                                    className="h-5 w-5"
                                                    aria-hidden="true"
                                                />
                                            )}
                                        </span>
                                    </Disclosure.Button>
                                </h3>
                                <Disclosure.Panel className="pt-6">
                                    <div className="space-y-4">
                                        {section.options.map(
                                            (option, optionIdx) => (
                                                <div
                                                    key={option.value}
                                                    className="flex items-center"
                                                >
                                                    <input
                                                        id={`filter-${section.id}-${optionIdx}`}
                                                        name={`${section.id}[]`}
                                                        defaultValue={
                                                            option.value
                                                        }
                                                        type="checkbox"
                                                        defaultChecked={
                                                            option.checked
                                                        }
                                                        className="h-4 w-4 rounded border-gray-300 text-dark-blue focus:ring-green"
                                                        // onClick={(e) => handleColor(e, optionIdx)}
                                                    />
                                                    <label
                                                        htmlFor={`filter-${section.id}-${optionIdx}`}
                                                        className="ml-3 min-w-0 flex-1 text-gray-500"
                                                    >
                                                        {option.label}
                                                    </label>
                                                </div>
                                            )
                                        )}
                                    </div>
                                </Disclosure.Panel>
                            </>
                        )}
                    </Disclosure>
                ))}
            </form>
        </div>
    );
};

export default FilterContent;
