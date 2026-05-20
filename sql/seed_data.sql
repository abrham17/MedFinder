-- MedFinder Ethiopia - Seed Data
-- Sample data for testing and initial setup

USE medfinder_ethiopia;

-- Insert Admin User (Password: admin123)
INSERT INTO admins (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@medfinder.ethiopia');

-- Insert Neighborhoods
INSERT INTO neighborhoods (name, description, zone) VALUES 
('Bole', 'Central business district with many shopping centers', 'East'),
('Kirkos', 'Residential and commercial area near Meskel Square', 'East'),
('Arada', 'Historical area with old markets', 'West'),
('Yeka', 'Growing residential area', 'East'),
('Lideta', 'Mixed residential and commercial', 'West'),
('Kolfe', 'Industrial and residential area', 'West'),
('Nefas Silk', 'Suburban residential area', 'South'),
('Akaky Kaliti', 'Industrial zone', 'South'),
('Bole Bulbula', 'Near Bole International Airport', 'East'),
('Gulele', 'Northern residential area', 'North');

-- Insert Medicines
INSERT INTO medicines (medicine_name, generic_name, category, description) VALUES 
('Insulin (Rapid)', 'Insulin Lispro', 'Diabetes', 'Fast-acting insulin for blood sugar control'),
('Insulin (Long-acting)', 'Insulin Glargine', 'Diabetes', 'Long-acting basal insulin'),
('Metformin 500mg', 'Metformin Hydrochloride', 'Diabetes', 'First-line medication for type 2 diabetes'),
('Amoxicillin 500mg', 'Amoxicillin Trihydrate', 'Antibiotic', 'Penicillin antibiotic for bacterial infections'),
('Amoxicillin 250mg', 'Amoxicillin Trihydrate', 'Antibiotic', 'Lower dose penicillin antibiotic'),
('Azithromycin 500mg', 'Azithromycin', 'Antibiotic', 'Macrolide antibiotic for respiratory infections'),
('Ciprofloxacin 500mg', 'Ciprofloxacin', 'Antibiotic', 'Fluoroquinolone antibiotic'),
('Paracetamol 500mg', 'Acetaminophen', 'Painkiller', 'Pain reliever and fever reducer'),
('Ibuprofen 400mg', 'Ibuprofen', 'Painkiller', 'NSAID for pain and inflammation'),
('Aspirin 100mg', 'Acetylsalicylic Acid', 'Painkiller', 'Blood thinner and pain reliever'),
('Omeprazole 20mg', 'Omeprazole', 'Gastric', 'Proton pump inhibitor for acid reflux'),
('Ranitidine 150mg', 'Ranitidine', 'Gastric', 'H2 blocker for heartburn'),
('Lisinopril 10mg', 'Lisinopril', 'Cardiovascular', 'ACE inhibitor for high blood pressure'),
('Amlodipine 5mg', 'Amlodipine', 'Cardiovascular', 'Calcium channel blocker'),
('Atorvastatin 20mg', 'Atorvastatin', 'Cardiovascular', 'Statin for cholesterol'),
('Salbutamol Inhaler', 'Albuterol', 'Respiratory', 'Bronchodilator for asthma'),
('Montelukast 10mg', 'Montelukast', 'Respiratory', 'Leukotriene receptor antagonist'),
('Cetirizine 10mg', 'Cetirizine', 'Allergy', 'Antihistamine for allergies'),
('Loratadine 10mg', 'Loratadine', 'Allergy', 'Non-drowsy antihistamine'),
('Fexofenadine 180mg', 'Fexofenadine', 'Allergy', 'Antihistamine for seasonal allergies'),
('Hydrochlorothiazide 25mg', 'HCTZ', 'Diuretic', 'Water pill for blood pressure'),
('Warfarin 5mg', 'Warfarin Sodium', 'Blood Thinner', 'Anticoagulant medication'),
('Digoxin 0.25mg', 'Digoxin', 'Cardiovascular', 'Heart medication'),
('Metoprolol 50mg', 'Metoprolol Tartrate', 'Cardiovascular', 'Beta blocker'),
('Prednisone 5mg', 'Prednisone', 'Anti-inflammatory', 'Corticosteroid'),
('Gabapentin 300mg', 'Gabapentin', 'Neurological', 'For nerve pain and seizures'),
('Pregabalin 75mg', 'Pregabalin', 'Neurological', 'For nerve pain and anxiety'),
('Tramadol 50mg', 'Tramadol', 'Painkiller', 'Opioid pain reliever'),
('Codeine 30mg', 'Codeine Phosphate', 'Painkiller', 'Mild opioid pain reliever'),
('Morphine 10mg', 'Morphine Sulfate', 'Painkiller', 'Strong opioid pain reliever'),
('Diazepam 5mg', 'Diazepam', 'Sedative', 'Benzodiazepine for anxiety'),
('Alprazolam 0.5mg', 'Alprazolam', 'Sedative', 'Benzodiazepine for panic disorder'),
('Sertraline 50mg', 'Sertraline', 'Antidepressant', 'SSRI for depression'),
('Fluoxetine 20mg', 'Fluoxetine', 'Antidepressant', 'SSRI for depression and anxiety'),
('Escitalopram 10mg', 'Escitalopram', 'Antidepressant', 'SSRI for anxiety and depression'),
('Levothyroxine 100mcg', 'Levothyroxine Sodium', 'Hormone', 'Thyroid hormone replacement'),
('Metformin 850mg', 'Metformin Hydrochloride', 'Diabetes', 'Higher dose metformin'),
('Glipizide 5mg', 'Glipizide', 'Diabetes', 'Sulfonylurea for diabetes'),
('Sitagliptin 100mg', 'Sitagliptin', 'Diabetes', 'DPP-4 inhibitor for diabetes'),
('Empagliflozin 10mg', 'Empagliflozin', 'Diabetes', 'SGLT2 inhibitor for diabetes'),
('Dulaglutide 0.75mg', 'Dulaglutide', 'Diabetes', 'GLP-1 agonist for diabetes'),
('Clopidogrel 75mg', 'Clopidogrel', 'Blood Thinner', 'Antiplatelet medication'),
('Esomeprazole 40mg', 'Esomeprazole', 'Gastric', 'PPI for severe acid reflux'),
('Pantoprazole 40mg', 'Pantoprazole', 'Gastric', 'PPI for acid reflux'),
('Famotidine 20mg', 'Famotidine', 'Gastric', 'H2 blocker for heartburn'),
('Losartan 50mg', 'Losartan', 'Cardiovascular', 'ARB for blood pressure'),
('Valsartan 80mg', 'Valsartan', 'Cardiovascular', 'ARB for blood pressure'),
('Carvedilol 12.5mg', 'Carvedilol', 'Cardiovascular', 'Beta blocker for heart failure'),
('Diltiazem 30mg', 'Diltiazem', 'Cardiovascular', 'Calcium channel blocker'),
('Verapamil 80mg', 'Verapamil', 'Cardiovascular', 'Calcium channel blocker'),
('Furosemide 40mg', 'Furosemide', 'Diuretic', 'Loop diuretic for edema'),
('Spironolactone 25mg', 'Spironolactone', 'Diuretic', 'Potassium-sparing diuretic'),
('Clonidine 0.1mg', 'Clonidine', 'Cardiovascular', 'Alpha agonist for blood pressure'),
('Methyldopa 250mg', 'Methyldopa', 'Cardiovascular', 'For hypertension in pregnancy'),
('Nifedipine 10mg', 'Nifedipine', 'Cardiovascular', 'Calcium channel blocker'),
('Nitroglycerin 0.4mg', 'Nitroglycerin', 'Cardiovascular', 'For angina'),
('Aspirin 75mg', 'Acetylsalicylic Acid', 'Blood Thinner', 'Low dose aspirin'),
('Clopidogrel 75mg', 'Clopidogrel', 'Blood Thinner', 'Antiplatelet'),
('Enoxaparin 40mg', 'Enoxaparin', 'Blood Thinner', 'Low molecular weight heparin'),
('Heparin 5000IU', 'Heparin Sodium', 'Blood Thinner', 'Anticoagulant'),
('Vitamin D3 1000IU', 'Cholecalciferol', 'Supplement', 'Vitamin D supplement'),
('Calcium Carbonate 500mg', 'Calcium Carbonate', 'Supplement', 'Calcium supplement'),
('Iron Sulfate 325mg', 'Ferrous Sulfate', 'Supplement', 'Iron supplement for anemia'),
('Folic Acid 5mg', 'Folic Acid', 'Supplement', 'Vitamin B9 supplement'),
('Vitamin B12 1000mcg', 'Cyanocobalamin', 'Supplement', 'Vitamin B12 supplement'),
('Multivitamin', 'Multivitamin Complex', 'Supplement', 'Daily multivitamin'),
('Omega-3 1000mg', 'Fish Oil', 'Supplement', 'Omega-3 fatty acids'),
('Probiotic', 'Probiotic Complex', 'Supplement', 'Digestive health supplement'),
('Zinc 50mg', 'Zinc Sulfate', 'Supplement', 'Zinc supplement'),
('Magnesium 400mg', 'Magnesium Oxide', 'Supplement', 'Magnesium supplement'),
('Vitamin C 500mg', 'Ascorbic Acid', 'Supplement', 'Vitamin C supplement');

-- Insert Sample Pharmacy (Password: pharmacy123)
INSERT INTO pharmacies (pharmacy_name, owner_name, email, phone, password, address, neighborhood_id, license_number, operating_hours, status) VALUES 
('Unity Pharmacy', 'Hana Mulu', 'unity@medfinder.ethiopia', '+251911234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bole Road, Atlas Area', 1, 'LIC-2023-001', '8:00 AM - 9:00 PM', 'active');

-- Insert Sample Inventory for Unity Pharmacy
INSERT INTO inventory (pharmacy_id, medicine_id, quantity, price, status, notes) VALUES 
(1, 1, 50, 250.00, 'in_stock', 'Refrigerated storage required'),
(1, 2, 30, 280.00, 'in_stock', 'Refrigerated storage required'),
(1, 3, 100, 180.00, 'in_stock', NULL),
(1, 4, 75, 120.00, 'in_stock', NULL),
(1, 8, 200, 15.00, 'in_stock', NULL),
(1, 9, 150, 25.00, 'in_stock', NULL),
(1, 11, 80, 45.00, 'limited', 'Low stock'),
(1, 12, 60, 35.00, 'in_stock', NULL),
(1, 13, 40, 55.00, 'in_stock', NULL),
(1, 14, 35, 60.00, 'in_stock', NULL),
(1, 17, 25, 180.00, 'in_stock', NULL),
(1, 18, 90, 40.00, 'in_stock', NULL),
(1, 19, 85, 45.00, 'in_stock', NULL),
(1, 20, 70, 50.00, 'in_stock', NULL),
(1, 21, 50, 30.00, 'in_stock', NULL);

-- Insert Another Sample Pharmacy (Pending Approval)
INSERT INTO pharmacies (pharmacy_name, owner_name, email, phone, password, address, neighborhood_id, license_number, operating_hours, status) VALUES 
('EthioCare Pharmacy', 'Tsegaye Bekele', 'ethiocare@medfinder.ethiopia', '+251911223344', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Kirkos, Near Meskel Square', 2, 'LIC-2023-002', '8:00 AM - 8:00 PM', 'pending');

-- Insert Another Sample Pharmacy (Active)
INSERT INTO pharmacies (pharmacy_name, owner_name, email, phone, password, address, neighborhood_id, license_number, operating_hours, status) VALUES 
('BlueCross Pharmacy', 'Abebech Tesfaye', 'bluecross@medfinder.ethiopia', '+251911334455', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Yeka, Megenagna', 4, 'LIC-2023-003', '7:00 AM - 10:00 PM', 'active');

-- Insert Sample Inventory for BlueCross Pharmacy
INSERT INTO inventory (pharmacy_id, medicine_id, quantity, price, status, notes) VALUES 
(3, 1, 40, 260.00, 'in_stock', 'Refrigerated storage required'),
(3, 3, 80, 175.00, 'in_stock', NULL),
(3, 4, 60, 115.00, 'limited', 'Restocking soon'),
(3, 8, 150, 14.00, 'in_stock', NULL),
(3, 11, 45, 42.00, 'out_of_stock', 'Expected restock in 2 days'),
(3, 13, 55, 52.00, 'in_stock', NULL),
(3, 18, 100, 38.00, 'in_stock', NULL);

-- Sample Search Logs
INSERT INTO search_logs (medicine_name, neighborhood_id, results_count) VALUES 
('Insulin', 1, 2),
('Metformin', 1, 2),
('Amoxicillin', NULL, 2),
('Paracetamol', 2, 0),
('Omeprazole', 4, 1);
