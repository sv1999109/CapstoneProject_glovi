import React from 'react'

export default function Numbers() {
  return (
    <>
    <section style={{background: "#ffd79c", color: "rgb(54 19 74)"}} className='w-full h-auto '>
        <div className=' mx-auto flex justify-left items-center'>
            <span className='w-1/2 h-auto p-5'>
                <img style={{width: "85%"}} src="globe.png" alt="" />
            </span>
            <span  className=' w-1/2  h-auto p-5'>
                <div style={{width: "60%"}}>
                <h1  className='text-3xl font-extrabold'>Your domestic & international shipping expert</h1>
                <p className='text-xl mt-4'>See why so many come to Secureship for all their shipping needs</p>
                <section className='flex justify-between items-center mt-4'>
                <div className='flex justify-between items-center w-1/2  h-20'>
                    <span style={{width: "2%"}} className='bg-white h-full'></span>
                    <span style={{width: "98%"}} className='p-3'>
                        <h1 className='text-5xl font-bold'>180+</h1>
                        <p className='text-l mt-2'>Shipped to Countries</p>
                    </span>
                </div>
                <div className='flex justify-between items-center w-1/2  h-20'>
                    <span style={{width: "2%"}} className='bg-white h-full'></span>
                    <span style={{width: "98%"}} className='p-3'>
                    <h1 className='text-5xl font-bold'>Millions</h1>
                        <p className='text-l  mt-2'>Shipments Completed</p>
                    </span>
                </div>
                </section>
                <section className='flex justify-between items-center mt-4'>
                <div className='flex justify-between items-center w-1/2  h-20'>
                    <span style={{width: "2%"}} className='bg-white h-full'></span>
                    <span style={{width: "98%"}} className='p-3'>
                    <h1 className='text-5xl font-bold'>36K</h1>
                        <p className='text-l  mt-2'>Shipped to Countries</p>
                    </span>
                </div>
                <div className='flex justify-between items-center w-1/2 h-20'>
                    <span style={{width: "2%"}} className='bg-white h-full'></span>
                    <span style={{width: "98%"}} className='p-3'>
                    <h1 className='text-5xl font-bold'>30+</h1>
                        <p className='text-l  mt-2'>Shipped to Countries</p>
                    </span>
                </div>
                </section>
                </div>
                
            </span>
        </div>
       
    </section>
    <img style={{width: "50%"}} src="layer.png" alt="" />
    </>
  )
}
