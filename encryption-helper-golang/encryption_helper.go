package main

import (
	"crypto/aes"
	"crypto/cipher"
	"crypto/rand"
	"encoding/base64"
	"encoding/json"
	"fmt"
	"os"
)

type Result struct {
	Result string `json:"result"`
}

func main() {
	if len(os.Args) != 3 {
		fmt.Println("Usage: ./main <encrypt|decrypt> <text>")
		return
	}

	key := os.Getenv("ENCRYPTION_KEY")
	if key == "" {
		fmt.Println("Encryption key not found in environment variables.")
		return
	}

	var res Result

	switch os.Args[1] {
	case "encrypt":
		// 加密
		ciphertext, err := encrypt([]byte(os.Args[2]), []byte(key))
		if err != nil {
			res.Result = fmt.Sprintf("Encryption error: %v", err)
		} else {
			res.Result = base64.URLEncoding.EncodeToString(ciphertext)
		}

	case "decrypt":
		// 解密
		ciphertext, err := base64.URLEncoding.DecodeString(os.Args[2])
		if err != nil {
			res.Result = fmt.Sprintf("Decryption error: %v", err)
		} else {
			decryptedText, err := decrypt(ciphertext, []byte(key))
			if err != nil {
				res.Result = fmt.Sprintf("Decryption error: %v", err)
			} else {
				res.Result = string(decryptedText)
			}
		}

	default:
		fmt.Println("Usage: ./main <encrypt|decrypt> <text>")
		return
	}

	// 将结果转换为 JSON 字符串
	jsonStr, err := json.Marshal(res)
	if err != nil {
		fmt.Println("JSON marshalling error:", err)
		return
	}

	// 打印 JSON 字符串
	fmt.Println(string(jsonStr))
}

func encrypt(plaintext, key []byte) ([]byte, error) {
	block, err := aes.NewCipher(key)
	if err != nil {
		return nil, err
	}
	ciphertext := make([]byte, aes.BlockSize+len(plaintext))
	iv := ciphertext[:aes.BlockSize]
	if _, err := rand.Read(iv); err != nil {
		return nil, err
	}
	stream := cipher.NewCFBEncrypter(block, iv)
	stream.XORKeyStream(ciphertext[aes.BlockSize:], plaintext)
	return ciphertext, nil
}

func decrypt(ciphertext, key []byte) ([]byte, error) {
	block, err := aes.NewCipher(key)
	if err != nil {
		return nil, err
	}
	if len(ciphertext) < aes.BlockSize {
		return nil, fmt.Errorf("ciphertext too short")
	}
	iv := ciphertext[:aes.BlockSize]
	ciphertext = ciphertext[aes.BlockSize:]
	stream := cipher.NewCFBDecrypter(block, iv)
	stream.XORKeyStream(ciphertext, ciphertext)
	return ciphertext, nil
}
