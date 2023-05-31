import { useState, useEffect } from 'react';

function RangeSlider() {
  const [minprice, setMinPrice] = useState(0);
  const [maxprice, setMaxPrice] = useState(10000);
  const [min, setMin] = useState(0);
  const [max, setMax] = useState(10000);
  const [minthumb, setMinThumb] = useState(0);
  const [maxthumb, setMaxThumb] = useState(0);

  useEffect(() => {
    mintrigger();
    maxtrigger();
  }, []);

  const mintrigger = () => {
    validation();
    setMinPrice(Math.min(minprice, maxprice - 500));
    setMinThumb(((minprice - min) / (max - min)) * 100);
  };

  const maxtrigger = () => {
    validation();
    setMaxPrice(Math.max(maxprice, minprice + 200));
    setMaxThumb(100 - (((maxprice - min) / (max - min)) * 100));
  };

  const validation = () => {
    if (/^\d*$/.test(minprice)) {
      if (minprice > max) {
        setMinPrice(9500);
      }
      if (minprice < min) {
        setMinPrice(min);
      }
    } else {
      setMinPrice(0);
    }
    if (/^\d*$/.test(maxprice)) {
      if (maxprice > max) {
        setMaxPrice(max);
      }
      if (maxprice < min) {
        setMaxPrice(200);
      }
    } else {
      setMaxPrice(10000);
    }
  };

  const handleMinChange = (event) => {
    setMinPrice(parseInt(event.target.value));
  };

  const handleMaxChange = (event) => {
    setMaxPrice(parseInt(event.target.value));
  };

  return (
    <div className="h-screen flex justify-center items-center">
      <div className="relative max-w-xl w-full">
        <div>
          <input
            type="range"
            step="100"
            min={min}
            max={max}
            onChange={handleMinChange}
            value={minprice}
            className="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer"
          />

          <input
            type="range"
            step="100"
            min={min}
            max={max}
            onChange={handleMaxChange}
            value={maxprice}
            className="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer"
          />

          <div className="relative z-10 h-2">
            <div className="absolute z-10 left-0 right-0 bottom-0 top-0 rounded-md bg-gray-200"></div>

            <div
              className="absolute z-20 top-0 bottom-0 rounded-md bg-green-300"
              style={{ right: `${maxthumb}%`, left: `${minthumb}%` }}
            ></div>

            <div
              className="absolute z-30 w-6 h-6 top-0 left-0 bg-green-300 rounded-full -mt-2"
              style={{ left: `${minthumb}%` }}
            ></div>

            <div
              className="absolute z-30 w-6 h-6 top-0 right-0 bg-green-300 rounded-full -mt-2"
              style={{ right: `${maxthumb}%` }}
            ></div>
          </div>
        </div>

        <div className="flex items-center justify-between pt-5 space-x-4 text-sm text-gray-700">
          <div>
            <input
              type="text"
              maxLength="5"
              onInput={mintrigger}
              value={minprice}
              onChange={handleMinChange}
              className="w-24 px-3 py-2 text-center border border-gray-200 rounded-lg bg-gray-50 focus:border-yellow-400 focus:outline-none"
            />
          </div>
          <div>
            <input
              type="text"
              maxLength="5"
              onInput={maxtrigger}
              value={maxprice}
              onChange={handleMaxChange}
              className="w-24 px-3 py-2 text-center border border-gray-200 rounded-lg bg-gray-50 focus:border-yellow-400 focus:outline-none"
            />
          </div>
        </div>
      </div>

    </div>
  );
}

export default RangeSlider;
