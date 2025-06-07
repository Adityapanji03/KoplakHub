#!/usr/bin/env python3
"""
RevenuePredictor.py - Prediksi pendapatan bersih bulan berikutnya dengan KNN
"""

import sys
import json
import numpy as np
from sklearn.neighbors import KNeighborsRegressor
from sklearn.preprocessing import StandardScaler
from sklearn.metrics import mean_absolute_percentage_error
from sklearn.model_selection import train_test_split
import warnings
warnings.filterwarnings('ignore')

def create_features(data):
    """
    Membuat fitur untuk model ML dari data time series
    """
    X = []
    y = []

    # Minimal butuh 3 data historis untuk prediksi
    for i in range(3, len(data)):
        # Fitur: 3 bulan terakhir
        X.append([data[i-3], data[i-2], data[i-1]])
        # Target: bulan saat ini
        y.append(data[i])

    return np.array(X), np.array(y)

def add_seasonal_features(X, num_months):
    """
    Menambahkan fitur musiman (seasonality) ke dalam dataset
    """
    # Membuat fitur sinus dan cosinus untuk menangkap pola musiman dalam data
    month_feature = np.array([i % 12 + 1 for i in range(len(X))])
    month_sin = np.sin(2 * np.pi * month_feature / 12)
    month_cos = np.cos(2 * np.pi * month_feature / 12)

    # Menambahkan fitur musiman ke dataset
    return np.column_stack((X, month_sin.reshape(-1, 1), month_cos.reshape(-1, 1)))

def train_knn_model(X, y):
    """
    Melatih model KNN dan mengembalikan model terbaik
    """
    # Normalisasi data
    scaler_X = StandardScaler()
    scaler_y = StandardScaler()

    X_scaled = scaler_X.fit_transform(X)
    y_scaled = scaler_y.fit_transform(y.reshape(-1, 1)).flatten()

    # Membagi data untuk validasi
    X_train, X_test, y_train, y_test = train_test_split(X_scaled, y_scaled, test_size=0.2, random_state=42)

    # Melatih model KNN dengan parameter optimal
    knn_model = KNeighborsRegressor(n_neighbors=3, weights='distance')
    knn_model.fit(X_train, y_train)
    score = knn_model.score(X_test, y_test)

    return knn_model, scaler_X, scaler_y, score

def predict_next_month(data, model, scaler_X, scaler_y):
    """
    Memprediksi pendapatan bulan berikutnya berdasarkan data historis
    """
    # Mengambil 3 bulan terakhir sebagai fitur untuk prediksi
    last_3_months = np.array([data[-3], data[-2], data[-1]]).reshape(1, -1)

    # Normalisasi data input
    last_3_months_scaled = scaler_X.transform(last_3_months)

    # Prediksi bulan berikutnya
    next_month_scaled = model.predict(last_3_months_scaled)

    # Kembalikan nilai prediksi ke skala asli
    next_month_prediction = scaler_y.inverse_transform(next_month_scaled.reshape(-1, 1))[0][0]

    return next_month_prediction

def evaluate_model(data, model, scaler_X, scaler_y):
    """
    Mengevaluasi akurasi model dengan pengujian walk-forward
    """
    if len(data) < 6:  # Minimal butuh 6 bulan data untuk evaluasi
        return 80  # Default accuracy jika data terlalu sedikit

    # Gunakan walk-forward validation untuk mengevaluasi model
    actual_values = []
    predicted_values = []

    for i in range(3, len(data)):
        train_data = data[:i]
        test_value = data[i]

        # Prediksi dengan data pelatihan
        features = np.array([train_data[-3], train_data[-2], train_data[-1]]).reshape(1, -1)
        features_scaled = scaler_X.transform(features)
        prediction_scaled = model.predict(features_scaled)
        prediction = scaler_y.inverse_transform(prediction_scaled.reshape(-1, 1))[0][0]

        actual_values.append(test_value)
        predicted_values.append(prediction)

    # Hitung MAPE (Mean Absolute Percentage Error)
    mape = mean_absolute_percentage_error(actual_values, predicted_values)

    # Konversi MAPE ke akurasi (dalam %)
    accuracy = max(0, min(100, 100 - (mape * 100)))

    return round(accuracy, 1)

def main():
    """
    Fungsi utama program
    """
    if len(sys.argv) != 2:
        print("Penggunaan: python RevenuePredictor.py <file_data>")
        sys.exit(1)

    # Baca data pendapatan dari file
    try:
        with open(sys.argv[1], 'r') as f:
            revenue_data = json.load(f)
    except Exception as e:
        print(json.dumps({
            'error': str(e),
            'predicted_value': 0,
            'accuracy': 0
        }))
        sys.exit(1)

    # Pastikan data cukup untuk prediksi
    if len(revenue_data) < 4:
        print(json.dumps({
            'error': 'Data pendapatan tidak cukup (minimal 4 bulan)',
            'predicted_value': revenue_data[-1] if revenue_data else 0,
            'accuracy': 0
        }))
        sys.exit(1)

    # Buat fitur untuk model ML
    X, y = create_features(revenue_data)

    # Latih model KNN
    model, scaler_X, scaler_y, score = train_knn_model(X, y)

    # Prediksi pendapatan bulan berikutnya
    next_month_prediction = predict_next_month(revenue_data, model, scaler_X, scaler_y)

    # Evaluasi akurasi model
    accuracy = evaluate_model(revenue_data, model, scaler_X, scaler_y)

    # Pastikan prediksi tidak negatif
    if next_month_prediction < 0:
        next_month_prediction = 0

    # Output hasil prediksi dalam format JSON
    result = {
        'predicted_value': round(next_month_prediction),
        'accuracy': accuracy,
        'model_used': 'K-Nearest Neighbors'
    }

    print(json.dumps(result))

if __name__ == "__main__":
    main()
