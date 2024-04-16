import React from 'react';

export default function Numbers() {
  return (
    <>
      <section style={{ background: "#ffd79c", color: "rgb(54 19 74)" }} className='w-full h-auto'>
        <div className='mx-auto flex flex-col md:flex-row justify-center items-center md:justify-start'>
          <span className='w-full md:w-1/2 h-auto p-5'>
            <img style={{ width: "85%" }} src="globe.png" alt="" />
          </span>
          <span className='w-full md:w-1/2 h-auto p-5'>
            <div style={{ width: "60%" }}>
              <h1 className='text-3xl md:text-4xl lg:text-5xl font-extrabold'>Your domestic & international shipping expert</h1>
              <p className='text-xl mt-4'>See why so many come to Secureship for all their shipping needs</p>
              <section className='flex flex-col md:flex-row justify-between items-center mt-8'>
                <div className='flex justify-between items-center w-full md:w-1/2 h-20'>
                  <span style={{ width: "2%" }} className='bg-white h-full'></span>
                  <span style={{ width: "98%" }} className='p-3 flex flex-col'>
                    <h1 className='text-4xl md:text-5xl font-bold mb-1'>250+</h1>
                    <p className='text-lg'>Shipped to Countries</p>
                  </span>
                </div>
                <div className='flex justify-between items-center w-full md:w-1/2 h-20 mt-4 md:mt-0'>
                  <span style={{ width: "2%" }} className='bg-white h-full'></span>
                  <span style={{ width: "98%" }} className='p-3 flex flex-col'>
                    <h1 className='text-4xl md:text-5xl font-bold mb-1'>7+</h1>
                    <p className='text-lg'>Customers</p>
                  </span>
                </div>
              </section>
              <section className='flex flex-col md:flex-row justify-between items-center mt-8'>
                <div className='flex justify-between items-center w-full md:w-1/2 h-20'>
                  <span style={{ width: "2%" }} className='bg-white h-full'></span>
                  <span style={{ width: "98%" }} className='p-3 flex flex-col'>
                    <h1 className='text-4xl md:text-5xl font-bold mb-1'>3+</h1>
                    <p className='text-lg'>Total Shipments</p>
                  </span>
                </div>
                <div className='flex justify-between items-center w-full md:w-1/2 h-20 mt-4 md:mt-0'>
                  <span style={{ width: "2%" }} className='bg-white h-full'></span>
                  <span style={{ width: "98%" }} className='p-3 flex flex-col'>
                    <h1 className='text-4xl md:text-5xl font-bold mb-1'>2+</h1>
                    <p className='text-lg'>Branches</p>
                  </span>
                </div>
              </section>
            </div>
          </span>
        </div>
      </section>
      <img style={{ width: "50%" }} src="layer.png" alt="" />
    </>
  )
}
