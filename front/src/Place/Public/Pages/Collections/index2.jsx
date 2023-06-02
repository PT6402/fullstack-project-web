/* eslint-disable react/prop-types */
import { useState, Fragment, useEffect } from "react";
import { Dialog, Disclosure, Menu, Transition } from "@headlessui/react";
import { XMarkIcon } from "@heroicons/react/24/outline";
import {
    ChevronDownIcon,
    FunnelIcon,
    MinusIcon,
    PlusIcon,
} from "@heroicons/react/20/solid";
import styles from "./index.module.scss";
import ProductList from "../../Components/ProductList";

import { useNavigate, useParams } from "react-router-dom";
import { useCollection } from "../../Hooks/useCollection";
import CartContent from "../../Components/CartContent";
import SideModal from "../../Components/SideModal";
import FilterContent from "../../Components/FilterContent";
// import RangeSlider from "../../Components/RangPrice";
export default function Collections() {
    // const [mobileFiltersOpen, setMobileFiltersOpen] = useState(false);
    const [isOpenFilter, setIsOpenFilter] = useState(false);
    const subCategories = [{ name: "All Shoes", href: "/shoe/view-all" }];
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
    const material = [
        {
            id: "material",
            name: "Material",
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
    // const [allShoes, setAllShoes] = useState();
    const [loaded, setLoaded] = useState("");

    const navigate = useNavigate();
    const { id: urlId } = useParams();

    const { getCollection } = useCollection();

    const [products, setProducts] = useState(null);
    const [collection, setCollection] = useState(null);

    useEffect(() => {
        const fetchProducts = async () => {
            const fetchedProducts = await getCollection();
            setProducts(fetchedProducts);
        };

        fetchProducts();
    }, []);
    console.log(products);



    useEffect(() => {
        if (products) {
            let selectedProducts;
            if (urlId === "product") {
                selectedProducts = products;
                //
            } else if (urlId == "men" || urlId == "women") {
                const arrayFilter = products[0].filter(
                    (product) => product.category_name === urlId
                );
                selectedProducts = [arrayFilter];
                console.log(products[0]);
            } else {
                selectedProducts = null;
            }
            console.log(selectedProducts);

            if (selectedProducts) {
                setCollection(...selectedProducts);
                setLoaded(true);
                //   setAllShoes(selectedProducts);
                console.log(selectedProducts);
            } else {
                navigate("/");
            }
        }
    }, [products, urlId]);
    const toggleFilterModal = () => {
        setIsOpenFilter((prevState) => !prevState);
    };
    console.log(collection);
    function updateInnerText(value, previousSibling) {
        previousSibling.innerText = value;
    }
    return (
        <div >

                <div className={`${styles.container} main-container `}>
                    {/* Mobile filter dialog */}
                    <SideModal toggleModal={toggleFilterModal}>
                {isOpenFilter && (
                    <FilterContent toggleFilterModal={toggleFilterModal} />
                )}
            </SideModal>
                    <main className="">
                        <div className="flex items-baseline justify-between pt-6 pb-6 z-20">
                            <h1 className="text-4xl font-bold tracking-tight text-dark-blue ">
                                All Products
                            </h1>

                            <div className="flex items-center ">
                                <Menu
                                    as="div"
                                    className="relative inline-block text-left"
                                >
                                    <div>
                                        <Menu.Button className="group inline-flex z-1 p-2 relative justify-end items-center text-2xl font-bold text-gray-700 hover:text-gray-900 rounded-xl ">
                                            Sort
                                            <ChevronDownIcon
                                                className="-mr-1 ml-1 h-5 w-5 flex-shrink-0 z-2 relative text-gray-400 group-hover:text-green"
                                                aria-hidden="true"
                                            />
                                        </Menu.Button>
                                    </div>

                                    <Transition
                                        as={Fragment}
                                        enter="transition ease-out duration-100"
                                        enterFrom="transform opacity-0 scale-95"
                                        enterTo="transform opacity-100 scale-100"
                                        leave="transition ease-in duration-75"
                                        leaveFrom="transform opacity-100 scale-100"
                                        leaveTo="transform opacity-0 scale-95"
                                    >
                                        <Menu.Items className="absolute text-center right-0 z-10 mt-2 w-60 origin-top-right rounded-2xl bg-white shadow-2xl ring-1   ring-black ring-opacity-5 focus:outline-none">
                                            <div className="py-1">
                                                <Menu.Item>
                                                    <p
                                                        // onClick={() => handleName(allShoes)}
                                                        className="block px-4 py-2 text-lg cursor-pointer hover:bg-light-blue hover:text-lime-400"
                                                    >
                                                        Alphabetically A-Z
                                                    </p>
                                                </Menu.Item>
                                                <Menu.Item id="low">
                                                    <p
                                                        // onClick={(e) => handlePrice(e, allShoes)}
                                                        id="low"
                                                        className="block px-4 py-2 text-lg cursor-pointer hover:bg-light-blue hover:text-white"
                                                    >
                                                        Price: Low to High
                                                    </p>
                                                </Menu.Item>
                                                <Menu.Item id="high">
                                                    <p
                                                        // onClick={(e) => handlePrice(e, allShoes)}
                                                        id="high"
                                                        className="block px-4 py-2 text-lg cursor-pointer hover:bg-light-blue hover:text-white"
                                                    >
                                                        Price: High to Low
                                                    </p>
                                                </Menu.Item>
                                            </div>
                                        </Menu.Items>
                                    </Transition>
                                </Menu>

                                <button
                                    type="button"
                                    className="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden"
                                    // onClick={() => setMobileFiltersOpen(true)}
                                    onClick={toggleFilterModal}
                                >
                                    <span className="sr-only">Filters</span>
                                    <FunnelIcon
                                        className="h-5 w-5"
                                        aria-hidden="true"
                                    />
                                </button>
                            </div>
                        </div>

                        <section
                            aria-labelledby="products-heading"
                            className="pt-6   "
                        >
                            <h2 id="products-heading" className="sr-only">
                                Products
                            </h2>

                            <div className="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4 sticky ">
                                {/* Filters */}
                                <div className="">
                                    <form className="hidden lg:block sticky top-40">
                                        <h3 className="sr-only">Categories</h3>
                                        <ul
                                            role="list"
                                            className="space-y-4 border-b border-gray-200 pb-6 text-sm font-medium text-gray-900"
                                        >
                                            {subCategories.map((category) => (
                                                <li
                                                    key={category.name}
                                                    className="text-2xl"
                                                >
                                                    <a href={category.href}>
                                                        {category.name}
                                                    </a>
                                                </li>
                                            ))}
                                        </ul>

                                        {colors.map((section) => (
                                            <Disclosure
                                                as="div"
                                                key={section.id}
                                                className="border-b border-gray-200 py-6 sticky"
                                            >
                                                {({ open }) => (
                                                    <>
                                                        <h3 className="-my-3 flow-root sticky">
                                                            <Disclosure.Button className="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500 sticky top-40">
                                                                <span className=" text-2xl text-gray-900">
                                                                    {
                                                                        section.name
                                                                    }
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
                                                        <Disclosure.Panel className="pt-6 relative">
                                                            <div className="space-y-4 sticky top-40">
                                                                {section.options.map(
                                                                    (
                                                                        option,
                                                                        optionIdx
                                                                    ) => (
                                                                        <div
                                                                            key={
                                                                                option.value
                                                                            }
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
                                                                                className="ml-3 text-sm text-gray-600"
                                                                            >
                                                                                {
                                                                                    option.label
                                                                                }
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
                                                className="border-b border-gray-200 py-6 sticky"
                                            >
                                                {({ open }) => (
                                                    <>
                                                        <h3 className="-my-3 flow-root">
                                                            <Disclosure.Button className="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                                                                <span className="text-2xl text-gray-900">
                                                                    {
                                                                        section.name
                                                                    }
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
                                                                    (
                                                                        option,
                                                                        optionIdx
                                                                    ) => (
                                                                        <div
                                                                            key={
                                                                                option.value
                                                                            }
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
                                                                                className="ml-3 text-sm text-gray-600"
                                                                            >
                                                                                {
                                                                                    option.label
                                                                                }
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
                                        {material.map((section) => (
                                            <Disclosure
                                                as="div"
                                                key={section.id}
                                                className="border-b border-gray-200 py-6 sticky"
                                            >
                                                {({ open }) => (
                                                    <>
                                                        <h3 className="-my-3 flow-root">
                                                            <Disclosure.Button className="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                                                                <span className="text-2xl text-gray-900">
                                                                    {
                                                                        section.name
                                                                    }
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
                                                                    (
                                                                        option,
                                                                        optionIdx
                                                                    ) => (
                                                                        <div
                                                                            key={
                                                                                option.value
                                                                            }
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
                                                                                className="ml-3 text-sm text-gray-600"
                                                                            >
                                                                                {
                                                                                    option.label
                                                                                }
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

                                        {/* / */}
                                        {/* <ul
                                            role="list"
                                            className="space-y-4 border-b border-gray-200 pb-6 text-sm font-medium text-gray-900"
                                        >
                                            <li

                                                className="text-2xl"
                                            >
                                                <div
                                                    className="rounded-lg p-4 sticky"
                                                    style={{
                                                        "max-width": "300px",
                                                    }}
                                                >
                                                    <div className="price-range p-4 sticky">
                                                        <span className="text-xl font-bold sticky">
                                                            $
                                                        </span>
                                                        <span className="text-xl font-bold sticky">
                                                            0
                                                        </span>
                                                        <input
                                                            className="w-full accent-black sticky"
                                                            type="range"
                                                            defaultValue={0}
                                                            min="0"
                                                            max="1000"
                                                            onInput={(event) =>
                                                                updateInnerText(
                                                                    event.target
                                                                        .value,
                                                                    event.target
                                                                        .previousElementSibling
                                                                )
                                                            }
                                                        />
                                                        <div className="-mt-2 flex w-full justify-between sticky">
                                                            <span className="text-xl text-gray-600 sticky">
                                                                0
                                                            </span>
                                                            <span className="text-xl text-gray-600 sticky">
                                                                1000
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul> */}
                                    </form>
                                </div>

                                {/* Product grid */}
                                <div className="lg:col-span-3 lg:pb-48 mb-80">
                                    {loaded && (
                                        <ProductList allShoes={collection} />
                                    )}
                                </div>
                            </div>
                        </section>
                    </main>
                </div>

        </div>
    );
}
