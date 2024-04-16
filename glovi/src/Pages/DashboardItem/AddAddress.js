import React, { useState } from 'react';

function AddAddress() {

  const addressFormStyles = {
    maxWidth: '400px',
    margin: '0 auto',
  };
  
  const inputStyles = {
    width: '100%',
    padding: '0.5rem',
    border: '1px solid #ccc',
    borderRadius: '4px',
    fontSize: '1rem',
  };
  
  const buttonStyles = {
    width: '100%',
    padding: '0.5rem',
    border: 'none',
    borderRadius: '4px',
    fontSize: '1rem',
    backgroundColor: '#007bff',
    color: '#fff',
    cursor: 'pointer',
  };

  return (
    <div style={addressFormStyles}>
    <div style={{ marginBottom: '1rem' }}>
      <label htmlFor="addressType">Address Type:</label>
      <select id="addressType" style={inputStyles}>
        <option value="Residential">Residential</option>
        <option value="Business">Business</option>
      </select>
    </div>
    <div style={{ marginBottom: '1rem' }}>
      <label htmlFor="address">Address:</label>
      <input type="text" id="address" style={inputStyles} />
    </div>
    <div style={{ marginBottom: '1rem' }}>
      <label htmlFor="created">Created:</label>
      <input type="date" id="created" style={inputStyles} />
    </div>
    <div style={{ textAlign: 'center' }}>
      <button style={buttonStyles}>Add Address</button>
    </div>
  </div>

  );
}

export default AddAddress;